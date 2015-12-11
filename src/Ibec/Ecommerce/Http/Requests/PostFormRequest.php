<?php namespace Ibec\Content\Http\Requests;

use Ibec\Admin\Http\Requests\LocaleRequest;

class PostFormRequest extends LocaleRequest {

	/**
	 * Array of rules applied to locale-specific fields
	 *
	 * @var array
	 */
	protected $localeRules = [
		'title'  => 'required_with:{{lang}}.teaser,{{lang}}.content|max:255',
		'slug'   => 'required_with:{{lang}}.title,alpha_dash|max:255|unique:post_nodes,slug,{{current}},slug,language_id,{{lang}}',
		'fields' => 'sometimes|required_with:{{lang}}.title,array',
	];

	/**
	 * Array of fields required at least for one locale
	 *
	 * @var array
	 */
	protected $localeRequired = [
		'title',
	];

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		//TODO auth here
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$root = $this->route('roots');

		$this->offsetSet('root_id', $root->id);

		$available = $root->category->descendantsAndSelf()->lists('id');

		/** @var \Ibec\Content\Post $post */
		$post = $this->route('posts');

		$rules = [
			'category_id' => 'in:'.implode(',', $available),
			'moderation' => 'sometimes|in:0,1,2',
		];

		if ($this->query->has('fastModeration'))
		{
			return $rules;
		}

		if (!$post)
		{
			$this->localeRules['slug'] = str_replace('{{current}}', 'NULL', $this->localeRules['slug']);
		}

		//TODO user_id cat be set explicitly only by user with proper access

		$rules['image_id'] = 'sometimes|numeric|exists:images,id';

		if (\Auth::user()->can('others.content-posts'))
		{
			$rules['user_id'] = 'exists:users,id';
		}
		else
		{
			$rules['user_id'] = 'in:'.\Auth::id();
		}

		foreach($root->fields as $field)
		{
			$class = 'Ibec\Admin\Fields\\'.ucfirst(camel_case($field->type));
			$this->localeRules['fields.'.$field->slug] = (new $class)->rules();
		}


		$rules = array_merge(parent::rules(), $rules);

		if ($post)
		{
			// Ensure that slug is not validated against existing one
			foreach ($this->getLocaleList() as $locale)
			{
				$slug = ($node = $post->$locale) ? $node->slug : 'NULL';
				$rules[$locale.'.slug'] = str_replace('{{current}}', $slug, $rules[$locale.'.slug']);
			}
		}

		return $rules;
	}

}
