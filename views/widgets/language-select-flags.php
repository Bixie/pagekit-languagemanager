<?php
/**
 * @var \Pagekit\View\View $view
 * @var \Pagekit\Widget\Model\Widget $widget
 * @var string $current_language
 * @var array $languages
 * @var array $all_languages
 * @var string $flag_path
 */
$id = uniqid('flags-');
?>

<form name="languageform" id="<?=$id?>" method="post" action="<?=$view->url('@languagemanager/setlanguage')?>">
    <ul class="uk-subnav uk-margin-remove uk-flex-middle uk-grid-width-1-<?=count($languages)?>">
    <?php foreach ($languages as $language => $locale) :
        $style = 'height: 20px; width: 30px; opacity: 0.7;';
        if ($language == $current_language) {
            $style = 'height: 23px; width: 33px;';
        }
        ?>
        <li>
            <a data-language="<?=$language?>" title="<?=$all_languages[$locale['locale_id']]?>" data-uk-tooltip="delay:300">
                <div class="uk-cover-background"
                     style=" <?=$style?> background-image: url('<?=$view->url()->getStatic($flag_path.'/'.$locale['flag'])?>')">
                </div>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
    <input type="hidden" name="language" value="<?=$current_language?>"/>
</form>
<script>
    jQuery(function ($) {
        var form = $('#<?=$id?>');
        $('.uk-subnav a', form).click(function (e) {
            form.get(0).language.value = $(this).data('language');
            form.submit();
        });
    })
</script>
