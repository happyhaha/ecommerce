<?php

namespace Ibec\Ecommerce;

use Ibec\Ecommerce\Database\Filter as MainModel;
use Ibec\Ecommerce\Database\FilterNode as NodeModel;

/**
 * FilterRepository - класс репозитория для всех запросов моделей на стороне контроллера админки
 */
class FilterRepository
{

    /**
     * Перечисление атрибутов позволенных для фильтрации
     */
    public $paramRules = [
        'id' => '=',
        'title' => 'like',
    ];

    public function findByPk($id)
    {
        $ret = MainModel::find($id);
        if ($ret) {
            return $ret;
        }

        throw Exception('Запись не найдена');
    }

    public function getNew()
    {
        return new MainModel();
    }

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

        // if ($title = $request->input('title')) {
        //     $categories = $categories->whereHas('nodes', function ($q) use ($title) {
        //         $q->where('title', 'like', '%'.$title.'%');
        //     });
        // }

        // if ($request->wantsJson()) {
        //     $fields = $request->input('fields', null);
        //     $data = $categories->get();
        //     if ($fields) {
        //         $data = $data->map(function ($item) use ($fields) {
        //             return array_only($item->toArray(), $fields);
        //         });
        //     }

        //     return $data;
        // }

        $ret = MainModel::where($params)->orderBy($sort[0], $sort[1])->paginate($limit);

        return $ret;
    }

    public function delete($id)
    {
        if (is_array($id)) {
            MainModel::whereIn('id', $id)->delete();
        } else {
            MainModel::where('id', $id)->delete();
        }
    }

    public function save(&$model, $input)
    {

        if ($model->validate($input)) {
            $nodes = [];

            if ($model->exists) {
                $nodes = $model->nodes->all();
            }

            $model->fill($input);
            $model->save();

            foreach (config('app.locales') as $locale) {
                if (isset($input[$locale])) {

                    $node = array_get($nodes, $locale, null);
                    $data = $input[$locale];
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
                        $node = new NodeModel();
                        $node->fill($filtered);
                        $node->filter_id = $model->id;
                        $node->language_id = $locale;
                        $node->save();
                    }
                }
            }

            return true;
        }

        return false;
    }
}
