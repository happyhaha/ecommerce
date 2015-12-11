<?php

namespace Ibec\Ecommerce;

abstract class BaseRepository
{
    protected $modelName;
    protected $paramRules = [];

    /**
     * Запрос на все записи модели с фильтрацией и пагинацией
     *
     * @param  array $params - параметры фильтрации
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Pagination\Paginator коллекция моделей
     */
    public function all($params)
    {
        $filters = [];

        $limit = isset($params['limit'])?$params['limit']:15;
        $sort = ['id','desc'];

        if (isset($params['sort'])) {
            $sortParams = explode('_', $params['sort']);
            if ($sortParams[2]=='asc' || $sortParams[2]=='desc') {
                $sort = $sortParams;
            }
        }

        foreach ($this->paramRules as $attribute => $rule) {
            if (isset($params[$attribute]) && !empty($params[$attribute])) {
                $vl = $params[$attribute];
                if ($rule=='like') {
                    $vl = '%'.$vl.'%';
                }
                $filters[] = [$attribute,$rule,$vl];
            }
        }
        $modelName = $this->modelName;
        $ret = $modelName::where($params)->orderBy($sort[0], $sort[1])->paginate($limit);

        return $ret;
    }

    /**
     * Удаление записи из модели
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $modelName = $this->modelName;
        if (is_array($id)) {
            $modelName::whereIn('id', $id)->delete();
        } else {
            $modelName::where('id', $id)->delete();
        }
    }

    /**
     * @return Eloquent
     */
    public function getNew()
    {
        $modelName = $this->modelName;
        return new $modelName();
    }

    /**
     * @param int $id
     * @return Eloquent
     * @throws Exception
     */
    public function findByPk($id)
    {
        $modelName = $this->modelName;
        $ret = $modelName::find($id);
        if ($ret) {
            return $ret;
        }

        throw Exception('Запись не найдена');
    }

    /**
     * @param Eloquent $model
     * @param string $relationKey
     * @param array $input
     */
    protected function saveNodes($model, $relationKey, $input = [])
    {
        $nodes = [];
        if ($model->exists) {
            $nodes = $model->nodes->all();
        }

        foreach (config('app.locales') as $locale) {
            if (isset($input[$locale])) {

                $node = array_get($nodes, $locale, null);
                $data = array_get($input, $locale, []);
                $filtered = array_filter($data, 'strlen');

                if ($node) {
                    if (!empty($filtered)) {
                        $node->update($filtered);
                        $node->language_id = $locale;
                        $nodes[$locale] = $node;
                    } else {
                        $node->delete();
                        unset($nodes[$locale]);
                    }
                } elseif ($filtered) {
                    $nodeClassName = $model->getNodeClass();
                    $node = new $nodeClassName();
                    $node->fill($filtered);
                    $node->{$relationKey} = $model->id;
                    $node->language_id = $locale;
                    $node->save();
                }
            }
        }
    }
}
