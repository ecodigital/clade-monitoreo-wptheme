<?php
global $data_query, $theme_title, $term;
$table_rows = get_field('table_rows');
$table_columns = get_field('table_columns');
?>
<div class="data-table">
  <?php
  if($data_query->have_posts()) :
    while($data_query->have_posts()) :
      $data_query->the_post();
      $file = get_field('pdf');
      $terms = clade_get_data_categories_ids();
      ?>
      <span class="button-container" data-categories="<?php echo implode(',', $terms); ?>"><?php clade_data_download_button(); ?></span>
      <?php
      wp_reset_postdata();
    endwhile;
  endif;
  ?>
  <table class="table">
    <?php if($table_columns) : ?>
      <thead>
        <tr>
          <?php foreach($table_columns as $col) : ?>
            <th scope="col"><?php echo $col->name; ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
    <?php endif; ?>
    <tbody>
      <?php
      if($table_rows) :
        foreach($table_rows as $row) :
          $children = get_terms(array(
            'taxonomy' => 'data-category',
            'hide_empty' => 0,
            'child_of' => $row->term_id
          ));
          $row_id = $row->term_id;
          if($children) {
            $first_child = array_shift($children);
            $row_id = $first_child->term_id;
          }
          ?>
          <tr>
            <th scope="row" <?php if($children) echo 'rowspan=' . (count($children)+1) . '"'; ?>><?php echo $row->name; ?></th>
            <?php
            if(!$children) :
              foreach($table_columns as $col) :
                ?>
                <td class="data-button" data-category="<?php echo $row->term_id; ?>,<?php echo $col->term_id; ?>"></td>
                <?php
              endforeach;
            else :
              ?>
              <th class="sub"><?php echo $first_child->name; ?></th>
              <?php
              foreach($table_columns as $col) :
                ?>
                <td class="data-button" data-category="<?php echo $first_child->term_id; ?>,<?php echo $col->term_id; ?>"></td>
                <?php
              endforeach;
            endif;
            ?>
          </tr>
          <?php
          if($children) :
            foreach($children as $child) :
              ?>
              <tr data-category="<?php echo $child->term_id; ?>">
                <th class="sub"><?php echo $child->name; ?></th>
                <?php
                foreach($table_columns as $col) :
                  ?>
                  <td class="data-button" data-category="<?php echo $child->term_id; ?>,<?php echo $col->term_id; ?>"></td>
                  <?php
                endforeach;
                ?>
              </tr>
              <?php
            endforeach;
          endif;
          ?>
          <?php
        endforeach;
      else :
        ?>
        <tr>
          <?php foreach($table_columns as $col) : ?>
            <td class="data-button" data-category="<?php echo $col->term_id; ?>"></td>
          <?php endforeach; ?>
        </tr>
        <?php
      endif;
      ?>
    </tbody>
  </table>
</div>
