<ul class="nav nav-pills">
    <li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
        <a href="<?php echo site_url(SITE_AREA .'/content/mail') ?>"><?php echo lang('mail_suscribed');?></a>
    </li>
    <li <?php echo $this->uri->segment(4) == 'template' ? 'class="active"' : '' ?>>
        <a href="<?php echo site_url(SITE_AREA .'/content/mail/template') ?>"><?php echo lang('mail_template') ?></a>
    </li>
    <li <?php echo $this->uri->segment(4) == 'list' ? 'class="active"' : '' ?>>
        <a href="<?php echo site_url(SITE_AREA .'/content/mail/lists') ?>"><?php echo lang('mail_lists');?></a>
    </li>
    <li <?php echo $this->uri->segment(4) == 'woki' ? 'class="active"' : '' ?>>
        <a href="<?php echo site_url(SITE_AREA .'/content/mail/wiki') ?>"><?php echo lang('mail_wiki');?></a>
    </li>
</ul>