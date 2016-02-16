<?php

namespace Ibec\Ecommerce;

use Exception;
use \Schema;

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

        $limit = isset($params['limit']) ? $params['limit'] : 15;
        $sort = ['id', 'desc'];

        if (isset($params['sort'])) {
            $sortParams = explode('_', $params['sort']);
            if ($sortParams[2] == 'asc' || $sortParams[2] == 'desc') {
                $sort = $sortParams;
            }
        }

        foreach ($this->paramRules as $attribute => $rule) {
            if (isset($params[$attribute]) && !empty($params[$attribute])) {
                $vl = $params[$attribute];
                if ($rule == 'like') {
                    $vl = '%' . $vl . '%';
                }
                $filters[] = [$attribute, $rule, $vl];
            }
        }

        $ret = $this->query()->where($filters)->orderBy($sort[0], $sort[1])->paginate($limit);

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
            $this->query()->whereIn('id', $id)->delete();
        } else {
            $this->query()->where('id', $id)->delete();
        }
    }

    /**
     * @return Eloquent
     */
    public function getNew()
    {
        $modelName = $this->modelName;
        $obj = new $modelName();
        if (Schema::hasColumn($obj->getTable(), 'status')) {
            $obj->status = 1;
        }
        return $obj;
    }

    /**
     * @param int $id
     * @return Eloquent
     * @throws Exception
     */
    public function findByPk($id)
    {
        $ret = $this->query()->find($id);
        if ($ret) {
            return $ret;
        }

        throw Exception('Запись не найдена');
    }

    /**
     * @param Eloquent $model
     * @param string $relationKey
     * @param array $input
     * @param function|null $fieldsSetCallback
     */
    public static function saveNodes($model, $relationKey, $input = [], $fieldsSetCallback = null)
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
                    if (is_callable($fieldsSetCallback)) {
                        call_user_func($fieldsSetCallback, $node);
                    }
                    $node->language_id = $locale;
                    $node->save();
                }
            }
        }
    }

    public function query()
    {
        return (new $this->modelName)->newQuery();
    }

    /**
     * @param $model
     * @return bool
     */
    public function hasImages($model)
    {
        $traitList = class_uses($model);
        $hasImages = false;
        foreach ($traitList as $trait) {
            if (mb_strpos($trait, 'HasImage', 0, 'UTF-8')!==false) {
                $hasImages = true;
            }
        }

        return $hasImages;
    }

    /**
     * @param $model
     * @param $data array
     * @return void
     */
    protected function saveImage($model, $data = [])
    {
        $mediaItems = array_get($data, 'Media', []);
        if ($mediaItems) {
            $rows = [];
            foreach ($mediaItems as $data) {
                $rows[$data['image_id']] = [
                    'title' => array_get($data, 'image_title'),
                    'alt' => array_get($data, 'image_alt'),
                    'cropped_coords' => array_get($data, 'cropped_coords', null),
                    'url' => array_get($data, 'url', null),
                    'subtype' => array_get($data, 'subtype', null),
                ];
            }

            $model->images()->sync($rows);
        } else {
            $model->images()->detach();
        }
    }

    protected function saveFiles($model, $data = [])
    {
        if ($files = array_get($data, 'fields.files')) {
            $model->files()->detach();

            foreach ($files as $field_slug => $file_id) {
                if ($file_id) {
                    $model->files()->attach([
                        $file_id => [
                            'field_slug' => $field_slug,
                        ]
                    ]);
                }
            }
        } else {
            $model->files()->detach();
        }
    }

}
