<div class="row wrapper">
    <div class="col-sm-4 hidden-xs js__disabledManipulation">
        <select class="input-sm form-control w-sm inline v-middle">
            <option value="delete">
                {{ trans('ecommerce::default.actions.delete_selected') }}
            </option>
        </select>
        <button onclick="deleteItem()" data-action="batchAction" data-url="{{ url('admin/ecommerce/'.$codename.'/batch') }}" class="btn btn-sm btn-default apply_bulk">
            {{ trans('ecommerce::default.actions.apply') }}
        </button>
    </div>
</div>
<script>
    function deleteItem() {
        confirm("Вы уверены удалить выбранные объекты?");

    }
</script>