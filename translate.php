<?php 
$jsonFileAccessModel = new JsonFileAccessModel($task['id'], $task['ref_lang']);
?>
<div class="container">
    <div class="old_form_wrapper">
    
    <form action="index.php?save_translate=<?=$task['id'];?>" method="POST">
        <div class="form_wrapper_1">
            <?php 
            $jsonFileAccessModel2 = new JsonFileAccessModel('languages');
            $languages = json_decode($jsonFileAccessModel2->read(), true);
            ?>

                <?php
                $original_lang = '';
                foreach ($languages as $lang) {
                    if ($lang['id'] == $task['ref_lang']) $original_lang = $lang['name'];
                }
                ?>
                <p>Язык оригинала:</p>
                <p><strong><?=$original_lang;?></strong></p>



                <?php 
                $translation_lang = '';
                foreach ($task['trans_lang'] as $lang) {
                    foreach ($languages as $value) {
                        if ($value['id'] == $lang) {
                            $translation_lang .= $value['name'];
                            $translation_lang .= "\n";
                        }
                    }
                }
                ?>
                <p>Языки перевода:</p> 
                <p><strong><?=$translation_lang;?></strong></p>



                <p>Крайний срок</p> 
                <p><strong><?=date('d.m.Y', strtotime($task['deadline']));?></strong></p>

        </div>

        <textarea class="original-text" readonly><?=$jsonFileAccessModel->read();?></textarea>

        <?php 
        foreach ($task['trans_lang'] as $lang) {
            $data = '';
            $filename = 'translate_' . $task['id'];
            $jsonFileAccessModel = new JsonFileAccessModel($filename, $lang);
            if ($jsonFileAccessModel->read() != false) $data = $jsonFileAccessModel->read();
            ?>
            <p class = "trans_lang"><strong><?=strtoupper($lang);?></strong></p>
            <textarea name="translation_text_<?=$lang;?>" class="translation-text"><?=$data;?></textarea>
        <?php } ?>

        <div class="form_wrapper_4">
            <div class="button_close">
                <?php if ($task['status'] == 'new' || $task['status'] == 'rejected') { ?>
                    <a  href="index.php?resolve_translate=<?=$task['id'];?>">Отправить на проверку</a>
                <?php } elseif ($task['status'] == 'resolved') { ?>
                    <p>Задание отправлено на проверку</p>
                <?php } elseif ($task['status'] == 'done') { ?>
                    <p>Задание выполнено</p>
                <?php } ?>
            </div>

                <?php if ($task['status'] != 'done') { ?>
                    <button>Сохранить</button>
                <?php } ?>

        </div>
    </form>
</div>
</div>
