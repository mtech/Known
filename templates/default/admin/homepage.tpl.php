<div class="row">

    <div class="col-md-10 col-md-offset-1">
                <?php echo $this->draw('admin/menu') ?>
        <h1>
            <?php echo \Idno\Core\Idno::site()->language()->_('Homepage content'); ?>
        </h1>

        <div class="explanation">
            <p>
                <?php echo \Idno\Core\Idno::site()->language()->_('Here you can choose what content visitors see on your site homepage. By default, all published content appears on the main page. If you want to hide some content types from the main page, you can turn them off below.'); ?>
            </p>
        </div>

        
        <div class="explanation"><?php echo \Idno\Core\Idno::site()->language()->_('Turn off content types to hide them from the homepage of your site.'); ?>
        </div>
        <br>
        <form action="<?php echo \Idno\Core\Idno::site()->config()->getDisplayURL() ?>admin/homepage" method="post"
              class="form-horizontal" enctype="multipart/form-data">

            <div class="control-group">
                <div class="">
                    <?php

                    if (!empty($vars['content_types'])) {
                        foreach ($vars['content_types'] as $content_type) {
                            /* @var \Idno\Common\ContentType $content_type */
                            ?>

                                <div class="content-type">
                                    <div class="row">
                                    <div class="col-md-2">
                                        
                                        <label class="homepage_<?php echo $content_type->getCategoryTitleSlug() ?>"
                                               for="homepage_toggle_<?php echo $content_type->getCategoryTitleSlug() ?>">
                                            <!--<?php echo $content_type->getIcon() ?>-->
                                            <strong><?php echo $content_type->getCategoryTitle() ?></strong>
                                        </label>
                                    </div>
                                    <div class="config-toggle col-md-4">
                                        
                                        <input type="checkbox" data-toggle="toggle" data-onstyle="info" name="default_feed_content[]"

                           data-on="<?php echo \Idno\Core\Idno::site()->language()->_('On'); ?>"
                           data-off="<?php echo \Idno\Core\Idno::site()->language()->_('Off'); ?>"

                                               value="<?php echo $content_type->getCategoryTitleSlug() ?>" <?php

                                                if (in_array($content_type->getEntityClass(), $vars['default_content_types'])) {
                                                    echo 'checked="checked"';
                                                }

                                                ?>
                                        />

                                    </div>
                                    </div>
                                </div>

                            <?php

                        }
                    }

                    ?>
                </div>
            </div>
            
<!--            <div class="control-group">
                <div class="">
                    <?php

                    if (!empty($vars['content_types'])) {
                        foreach ($vars['content_types'] as $content_type) {
                            /* @var \Idno\Common\ContentType $content_type */
                            ?>

                                <div class="content-type">
                                    <p>
                                        <input type="checkbox" name="default_feed_content[]"
                                               id="homepage_toggle_<?php echo $content_type->getCategoryTitleSlug() ?>"
                                               value="<?php echo $content_type->getCategoryTitleSlug() ?>" <?php

                                                if (in_array($content_type->getEntityClass(), $vars['default_content_types'])) {
                                                    echo 'checked="checked"';
                                                }

                                                ?>/>
                                        <label class="homepage_<?php echo $content_type->getCategoryTitleSlug() ?>"
                                               for="homepage_toggle_<?php echo $content_type->getCategoryTitleSlug() ?>">
                                        <?php echo $content_type->getIcon() ?>
                                        <?php echo $content_type->getCategoryTitle() ?>
                                        </label>
                                    </p>
                                </div>

                            <?php

                        }
                    }

                    ?>
                </div>
            </div>-->            
            
            <div class="control-group">
                <div class="">
                    <button type="submit" class="btn btn-primary"><?php echo \Idno\Core\Idno::site()->language()->_('Save'); ?></button>
                </div>
            </div>
            <?php echo \Idno\Core\Idno::site()->actions()->signForm('/admin/homepage') ?>

        </form>
    </div>

</div>
