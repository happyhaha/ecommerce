<?php namespace Ibec\Ecommerce\Database;

use Baum\SetMapper;

class SortedMapper extends SetMapper {

	/**
	 * Maps a tree structure into the database
	 *
	 * @param   array    $tree
	 * @param   mixed    $parentKey
	 * @param   array    $affectedKeys
	 * @param   int|null $lft
	 * @return  boolean
	 */
	protected function mapTreeRecursive(array $tree, $parentKey = null, &$affectedKeys = array(), $lft = null) {
		// For every attribute entry: We'll need to instantiate a new node either
		// from the database (if the primary key was supplied) or a new instance. Then,
		// append all the remaining data attributes (including the `parent_id` if
		// present) and save it. Finally, tail-recurse performing the same
		// operations for any child node present. Setting the `parent_id` property at
		// each level will take care of the nesting work for us.

		$rgt = true;

		foreach($tree as $attributes) {
			/** @var \Baum\Node $node */
			$node = $this->firstOrNew($this->getSearchAttributes($attributes));

			$data = $this->getDataAttributes($attributes);

			if ( !is_null($parentKey) )
				$data[$node->getParentColumnName()] = $parentKey;

			if (is_null($lft))
			{
				if ($parentKey)
				{
					$lft = $this->node->{$this->node->getLeftColumnName()} + 1;
				}
				else
				{
					$lft = $node->{$node->getLeftColumnName()};
				}
			}

			$data[$node->getLeftColumnName()] = $lft;

			$node->fill($data);

			$result = $node->save();

			if ( ! $result ) return false;

			$affectedKeys[] = $node->getKey();

			$children = array_get($attributes, $this->getChildrenKeyName(), []);

			if (count($children) > 0) {
					$result = $this->mapTreeRecursive($children, $node->getKey(), $affectedKeys, $lft+1);

					if ( ! $result ) return false;

					$rgt = $result+1;
			}
			else
			{
				$rgt = $lft+1;
			}

			$node->{$node->getRightColumnName()} = $rgt;

			if (is_null($parentKey))
				$node->parent_id = null;
			$node->save();

			$lft = $rgt+1;
		}
		return $rgt;
	}

}