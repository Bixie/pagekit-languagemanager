<?php
/**
 * @var \Pagekit\View\View $view
 * @var \Pagekit\Widget\Model\Widget $widget
 * @var string $current_language
 * @var array $languages
 * @var array $all_languages
 */

?>

<form name="languageform" method="post" action="<?=$view->url('@languagemanager/setlanguage')?>">
    <select name="language" onchange="document.languageform.submit()">
        <?php foreach ($languages as $language => $locale) : ?>
            <option value="<?=$language?>"<?=($language == $current_language ? ' selected="selected"' : '')?>><?=$all_languages[$locale['locale_id']]?></option>
        <?php endforeach; ?>
    </select>
</form>
