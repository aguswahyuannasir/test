<table class="table table-hover datatable-responsive" id="table" data-url="<?php echo $table['url']; ?>">
    <thead>
        <tr class="column">
            <?php
            foreach ($table['columns'] as $key => $column) {
                echo '<th style="' . (isset($column['width']) ? 'width:' . $column['width'] : '') . '" class="' . (isset($column['class']) ? $column['class'] : '') . '" data-data="' . $key . '" data-sort="' . (isset($column['sort']) ? $column['sort'] : '') . '">' . $column['title'] . '</th>';
            }
            ?>
        </tr>
        <tr class="filter">
            <?php $filter = $this->session->userdata($filter_name); ?>
            <?php foreach ($table['columns'] as $key => $column) { ?>
                <td>
                    <?php if ($column['filter']['type'] == 'text') : ?>
                        <div class="form-group-feedback form-group-feedback-left">
                            <input type="text" name="<?php echo $key; ?>" class="form-control form-control-sm" autocomplete="off" value="<?php echo ($filter) ? $filter[$key] : ''; ?>">
                            <div class="form-control-feedback form-control-feedback-sm form-filter">
                                <i class="icon-search4"></i>
                            </div>
                        </div>
                    <?php elseif ($column['filter']['type'] == 'date') : ?>
                        <div class="form-group has-feedback-left">
                            <input type="text" name="<?php echo $key; ?>" class="form-control form-control-sm date" autocomplete="off">
                            <div class="form-control-feedback form-control-feedback-sm">
                                <i class="icon-search4"></i>
                            </div>
                        </div>
                    <?php elseif ($column['filter']['type'] == 'dropdown') : ?>
                        <?php echo form_dropdown($key, $column['filter']['dropdown'], ($filter) ? $filter[$key] : NULL, ['class' => 'form-control form-control-sm']); ?>
                    <?php elseif ($column['filter']['type'] == 'action') : ?>
                        <button type="button" class="btn btn-primary btn-sm"><i class="icon-filter3"></i></button>
                        <?php endif; ?>
                </td>
            <?php } ?>
        </tr>
    </thead>
</table>