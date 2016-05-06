<?php if ($this->Paginator->hasPage(null,2)) : ?> 
<div class="<?php echo isset($divClass)?$divClass:'paginator clearfix'; ?>">
        <ul class="pagination pull-right">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
    </div>
<?php endif; ?>