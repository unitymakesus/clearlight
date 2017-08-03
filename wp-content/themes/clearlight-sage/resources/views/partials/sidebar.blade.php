@php
//GET CHILD PAGES IF THERE ARE ANY
$children = get_pages('child_of='.$post->ID);

//GET PARENT PAGE IF THERE IS ONE
$parent = $post->post_parent;

//DO WE HAVE SIBLINGS?
$siblings =  get_pages('child_of='.$parent);

if( count($children) != 0) {
  $args = array(
    'depth' => 1,
    'title_li' => '',
    'child_of' => $post->ID
  );

} elseif($parent != 0) {
  $args = array(
    'depth' => 1,
    'title_li' => '',
    'child_of' => $parent
  );
}
@endphp

@if(count($siblings) > 1 && !is_null($args))
<div class="widget subpages card-panel background-dark-green">
  <h3 class="widgettitle">More {{ get_the_title($parent) }}</h3>
  <ul class="pages-list">
    {{wp_list_pages($args)}}
  </ul>
</div>
@endif
