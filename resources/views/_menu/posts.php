<ui-select ng-model="additions.posts.link.id"
		   ng-init="loadProvider('posts', '<?php echo e($url); ?>')"
		   theme="bootstrap"
		   ng-disabled="disabled" style="min-width: 300px;">
	<ui-select-match
		placeholder="Select a post in the list">{{$select.selected.title}}</ui-select-match>
	<ui-select-choices group-by="'category.title'" repeat="post in providers.posts">
		<div ng-bind-html="post.title"></div>
		<small>
			category: {{post.category.title}}
		</small>
	</ui-select-choices>
</ui-select>