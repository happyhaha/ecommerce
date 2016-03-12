<?php

namespace Ibec\Ecommerce;

use Ibec\Ecommerce\Database\ProductCategory as MainModel;
use Ibec\Ecommerce\Database\FilterGroup;
use DB;
use App\Models\Tag;
/**
 * Класс репозитория для всех запросов моделей на стороне контроллера админки
 */
class ProductCategoryRepository extends BaseRepository
{

    /**
     * Перечисление атрибутов позволенных для фильтрации
     */
    public $paramRules = [
        'id' => '=',
        'title' => 'like',
    ];

    public function __construct(MainModel $model)
    {
        $this->modelName = get_class($model);
    }

    public function save(&$model, $inputData)
    {
        $mainData = $inputData['ProductCategory'];
        if ($model->validate($mainData)) {

            $model->fill($mainData);
            if (!$model->exists) {
                $model->slug = $model->createSlug($mainData['ru']['title']);
            }

            $model->save();
            $this->saveNodes($model, 'product_category_id', $mainData);
            //записать в junction table
            DB::delete('delete from tag_category where category_id = :id', ['id' => $model->id]);
            foreach($mainData['tags'] as $tag)
            {
                DB::insert('insert into tag_category (category_id, tag_id) values (?, ?)', [$model->id, $tag]);
            }
            if ($this->hasImages($model)) {
                $this->saveImage($model, $inputData);
            }

            $filters = array_get($inputData, 'FilterGroup', []);

            $filterIds = [];
            foreach ($filters as $filterData) {
                if (isset($filterData['id']) && $filterData['id']!='') {
                    $filterGroup = FilterGroup::find($filterData['id']);
                    $filterGroup->update($filterData);
                } else {
                    $filterGroup = new FilterGroup();
                    $filterGroup->fill($filterData);
                    $filterGroup->product_category_id = $model->id;
                    if ($filterGroup->validate($filterData)) {
                        $filterGroup->save();
                    }
                }

                if ($filterGroup->id) {
                    $filterIds[] = $filterGroup->id;
                    $this->saveNodes($filterGroup, 'filter_group_id', $filterData);
                }
            }

            FilterGroup::where('product_category_id', '=', $model->id)->whereNotIn('id', $filterIds)->delete();

            return true;
        }

        return false;
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection
     */

    public static function buildTree(array &$elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = self::buildTree($elements, $element->id);
                if ($children) {
                    $element->children = $children;
                }
                $branch[$element->id] = $element;
            }
        }
        return $branch;
    }

    public function getTree($id = "")
    {   
        // $array = DB::select('SELECT product_categories.id,product_categories.parent_id,product_category_nodes.title FROM `product_categories`
        //     JOIN product_category_nodes
        //     ON product_category_nodes.product_category_id = product_categories.id;');
        // $tree = self::buildTree($array);
        if($id === null) //выводим все дерево если Создаем категорию
        {
            $models = MainModel::where('id', '>', 0)->orderBy('lft', 'asc')->get();
        }
        else // если редактируем то не выводим ее и детей
        {
            $models = MainModel::where('id', '>', 0)->orderBy('lft', 'asc')->get();
        }
        

        $html = [
            '' => 'Главная категория',
        ];
        foreach ($models as $model) {
            $html[$model->id] = str_repeat("&mdash;", $model->depth).$model->getNodeValue('title', 'ru');
            if ( array_key_exists('children', $model) ) {
                $html.= toSelect($model['children'], $model->depth);
            }
        }
        
        return $html;
    }

    public function getPlainTree()
    {
        $models = MainModel::where('id', '>', 0)->orderBy('lft', 'asc');

        return $models;
    }

    public function getPlainTreeArray()
    {
        return DB::select('SELECT product_categories.id,product_categories.parent_id,product_category_nodes.title FROM `product_categories`
            JOIN product_category_nodes
            ON product_category_nodes.product_category_id = product_categories.id;');
    }


}
