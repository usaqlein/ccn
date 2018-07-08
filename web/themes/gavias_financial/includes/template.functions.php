<?php
function gavias_financial_base_url(){
  global $base_url;
  $theme_path = drupal_get_path('theme', 'gavias_financial');
  return $base_url . '/' . $theme_path . '/';
}

function gavias_financial_preprocess_node(&$variables) {
  $date = $variables['node']->getCreatedTime();
  $variables['date'] = date( 'j F Y', $date);

  $variables['default'] = $variables['view_mode'] == 'default';
  $variables['card'] = $variables['view_mode'] == 'card';
  $variables['box'] = $variables['view_mode'] == 'box';
  $variables['text'] = $variables['view_mode'] == 'text';
  $variables['full'] = $variables['view_mode'] == 'full';

  switch ($variables['view_mode']) {
    case 'box':
      $variables['#attached']['library'][] = 'gavias_financial/gavias-box';
      break;
    case 'card':
      $variables['#attached']['library'][] = 'gavias_financial/gavias-card';
      break;
    case 'full':
      $variables['#attached']['library'][] = 'gavias_financial/gavias-full';
      break;
  }

  $fullUrl = $variables['elements']['#node']->toUrl()->setAbsolute()->toString();

  if(strpos($fullUrl, 'https://') !== false) {
    $fullUrlArr = explode('https://', $fullUrl);
    $fullUrlArr[0] = 'https%3A//';
    $alterFullUrl = implode($fullUrlArr);
  }

  if (strpos($fullUrl, 'http://') !== false) {
    $fullUrlArr = explode('http://', $fullUrl);
    $fullUrlArr[0] = 'http%3A//';
    $alterFullUrl = implode($fullUrlArr);
  }

  else {
    $alterFullUrl = FALSE;
  }

  if($alterFullUrl) {
    $variables['fb_share'] = 'https://www.facebook.com/sharer/sharer.php?u=' .$alterFullUrl . '';
    $variables['twitter_share'] = 'https://twitter.com/home?status=' . $alterFullUrl . '';
  }
  else {
    //hardcoded share site
    $variables['fb_share'] = 'https://www.facebook.com/sharer/sharer.php?u=http%3A//crytunity.com';
    $variables['twitter_share'] = 'https://twitter.com/home?status=http%3A//cryptunity.com';
  }

  if ($variables['teaser'] || !empty($variables['content']['comments']['comment_form'])) {
    unset($variables['content']['links']['comment']['#links']['comment-add']);
  }
  if ($variables['node']->getType() == 'article') {
      $node = $variables['node'];
      $variables['comment_count'] = $node->get('comment')->comment_count;
      $post_format = 'standard';
      try{
         $field_post_format = $node->get('field_post_format');
         if(isset($field_post_format->value) && $field_post_format->value){
            $post_format = $field_post_format->value;
         }
      }catch(Exception $e){
         $post_format = 'standard';
      }

      $iframe = '';
      if($post_format == 'video' || $post_format == 'audio'){
         try{
            $field_post_embed = $node->get('field_post_embed');
            if(isset($field_post_embed->value) && $field_post_embed->value){
               $autoembed = new AutoEmbed();
               $iframe = $autoembed->parse($field_post_embed->value);
            }else{
               $iframe = '';
               $post_format = 'standard';
            }
         }
         catch(Exception $e){
            $post_format = 'standard';
         }
      }
      $variables['gva_iframe'] = $iframe;
      $variables['post_format'] = $post_format;

  } elseif($variables['node']->getType() == 'special') {
    $node = $variables['node'];
    $variables['comment_count'] = $node->get('comment')->comment_count;
  }
  $variables['field_names'] = implode(', ', array_keys($variables['content']));
}

function gavias_financial_preprocess_node__article(&$variables){
  $x = 'i am here';
}

function gavias_financial_preprocess_node__special(&$variables){
  $x = 'i am here';
}


function gavias_financial_preprocess_node__article__card(&$variables){

  $content = $variables['content']['_layout_builder'][0]['content'];

  foreach ($content as $content_number) {
    if(is_array($content_number) && array_key_exists('#plugin_id', $content_number)) {
      switch ($content_number['#plugin_id']) {
        case 'field_block:node:article:field_content_category':
          $variables['content']['field_content_category'] = $content_number;
          break;
        case 'field_block:node:article:field_image':
          $variables['content']['field_image'] = $content_number;
          break;
        case 'field_block:node:article:field_tags':
          $variables['content']['field_tags'] = $content_number;
          break;
        case 'field_block:node:article:field_punchline':
          $variables['content']['field_punchline'] = $content_number;
          break;
        case 'field_block:node:article:field_tax_embed_one':
          $variables['content']['field_tax_embed_one'] = $content_number;
          break;
        case 'field_block:node:article:field_post_gallery':
          $variables['content']['field_post_gallery'] = $content_number;
          break;
        case 'field_block:node:article:field_alpha_sub_category':
          $variables['content']['content_sub_category'] = $content_number;
          break;
        case 'field_block:node:article:field_beta_sub_category':
          $variables['content']['content_sub_category'] = $content_number;
          break;
        case 'field_block:node:article:field_charlie_sub_category':
          $variables['content']['content_sub_category'] = $content_number;
          break;
        case 'field_block:node:article:field_delta_sub_category':
          $variables['content']['content_sub_category'] = $content_number;
          break;
      }
    }
  }
}
function gavias_financial_preprocess_node__special__card(&$variables){

  $content = $variables['content']['_layout_builder'][0]['content'];

  foreach ($content as $content_number) {
    if(is_array($content_number) && array_key_exists('#plugin_id', $content_number)) {
      switch ($content_number['#plugin_id']) {
        case 'field_block:node:special:field_content_category':
          $variables['content']['field_content_category'] = $content_number;
          break;
        case 'field_block:node:special:field_special_image':
          $variables['content']['field_special_image'] = $content_number;
          break;
        case 'field_block:node:special:field_tags':
          $variables['content']['field_tags'] = $content_number;
          break;
        case 'field_block:node:special:field_punchline':
          $variables['content']['field_punchline'] = $content_number;
          break;
        case 'field_block:node:special:field_tax_embed_one':
          $variables['content']['field_tax_embed_one'] = $content_number;
          break;
        case 'field_block:node:special:field_block_one':
          $variables['content']['field_block_one'] = $content_number;
          break;
        case 'field_block:node:special:field_special_sub_category':
          $variables['content']['field_special_sub_category'] = $content_number;
          break;
      }
    }
  }
}
function gavias_financial_preprocess_node__special__box(&$variables){

  $content = $variables['content']['_layout_builder'][0]['content'];

  foreach ($content as $content_number) {
    if(is_array($content_number) && array_key_exists('#plugin_id', $content_number)) {
      switch ($content_number['#plugin_id']) {
        case 'field_block:node:special:field_content_category':
          $variables['content']['field_content_category'] = $content_number;
          break;
        case 'field_block:node:special:field_special_image':
          $variables['content']['field_special_image'] = $content_number;
          break;
        case 'field_block:node:special:field_tags':
          $variables['content']['field_tags'] = $content_number;
          break;
        case 'field_block:node:special:field_punchline':
          $variables['content']['field_punchline'] = $content_number;
          break;
        case 'field_block:node:special:field_tax_embed_one':
          $variables['content']['field_tax_embed_one'] = $content_number;
          break;
        case 'field_block:node:special:field_block_one':
          $variables['content']['field_block_one'] = $content_number;
          break;
        case 'field_block:node:special:field_special_sub_category':
          $variables['content']['field_special_sub_category'] = $content_number;
          break;
      }
    }
  }
}

function gavias_financial_preprocess_node__article__box(&$variables){

  $content = $variables['content']['_layout_builder'][0]['content'];

  foreach ($content as $content_number) {
    if(is_array($content_number) && array_key_exists('#plugin_id', $content_number)) {
      switch ($content_number['#plugin_id']) {
        case 'field_block:node:article:field_content_category':
          $variables['content']['field_content_category'] = $content_number;
          break;
        case 'field_block:node:article:field_image':
          $variables['content']['field_image'] = $content_number;
          break;
        case 'field_block:node:article:field_tags':
          $variables['content']['field_tags'] = $content_number;
          break;
        case 'field_block:node:article:field_punchline':
          $variables['content']['field_punchline'] = $content_number;
          break;
        case 'field_block:node:article:field_tax_embed_one':
          $variables['content']['field_tax_embed_one'] = $content_number;
          break;
        case 'field_block:node:article:field_post_gallery':
          $variables['content']['field_post_gallery'] = $content_number;
          break;
        case 'field_block:node:article:field_alpha_sub_category':
          $variables['content']['content_sub_category'] = $content_number;
          break;
        case 'field_block:node:article:field_beta_sub_category':
          $variables['content']['content_sub_category'] = $content_number;
          break;
        case 'field_block:node:article:field_charlie_sub_category':
          $variables['content']['content_sub_category'] = $content_number;
          break;
        case 'field_block:node:article:field_delta_sub_category':
          $variables['content']['content_sub_category'] = $content_number;
          break;
      }
    }
  }
}

function gavias_financial_preprocess_node__portfolio(&$variables){
  $node = $variables['node'];
  
  // Override lesson list on single course
  $output = '';
  $count_information = 0;
  if($node->hasField('field_portfolio_information')){
    $informations = $node->get('field_portfolio_information');
    $count_information = count($informations);
    foreach ($informations as $key => $information) {
      $texts = preg_split('/--/', $information->value);
        $information_text = '';
        foreach ($texts as $k => $text) {
          $information_text .= '<span>' . $text . '</span>';
        }
      $output .= '<div class="item-information">' . $information_text . '</div>';
    }
  }
  $variables['count_information'] = $count_information;
  $variables['informations'] = $output;
}


function gavias_financial_preprocess_breadcrumb(&$variables){
  $variables['#cache']['max-age'] = 0;
  
  $request = \Drupal::request();
  $title = '';
  if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
    $title = \Drupal::service('title_resolver')->getTitle($request, $route);
  }

  if($variables['breadcrumb']){
     foreach ($variables['breadcrumb'] as $key => &$value) {
      if($value['text'] == 'Node'){
        unset($variables['breadcrumb'][$key]);
      }
    }

    if(!empty($title)){
      $variables['breadcrumb'][] = array(
        'text' => ''
      );
      $variables['breadcrumb'][] = array(
        'text' => $title
      );  
    }  
  }
}