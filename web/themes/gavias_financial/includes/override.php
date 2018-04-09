<?php
function gavias_financial_preprocess_views_view_grid(&$variables) {
    /** @var Drupal\views\ViewExecutable $view */
   $view = $variables['view'];
   if($view) {
     /** @var Drupal\views\Entity\View $viewStorage */
     $viewStorage = $view->storage;
     if($viewStorage) {
       $variables['gridViewName'] = 'grid-'.$viewStorage->id();
     }
   }
   $rows = $variables['rows'];
   $style = $view->style_plugin;
   $options = $style->options;
   $variables['gva_masonry']['class'] = '';
   $variables['gva_masonry']['class_item'] = '';
   if(strpos($options['row_class_custom'] , 'masonry') || $options['row_class_custom'] == 'masonry' ){
      $variables['gva_masonry']['class'] = 'post-masonry-style row';
      $variables['gva_masonry']['class_item'] = 'item-masory';
   }
}
