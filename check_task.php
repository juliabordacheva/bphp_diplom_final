<?php 
$jsonFileAccessModel = new JsonFileAccessModel($task['id'], $task['ref_lang']);
?>
<div class="container">
    <div class="old_form_wrapper">

        <form action="index.php?done_task=<?=$task['id'];?>" method="POST">
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
                    <p><strong><?=$task['deadline']?></strong></p>
                    <div class="button_close"><a href="index.php<?=$filter_param;?>">Закрыть</a></div>


            </div>

            <textarea class="original-text" readonly><?=$jsonFileAccessModel->read();?></textarea>

            <?php
            foreach ($task['trans_lang'] as $lang) {
                $data = '';
                $filename = 'translate_' . $task['id'];
                $jsonFileAccessModel = new JsonFileAccessModel($filename, $lang);
                if ($jsonFileAccessModel->read() != false) $data = $jsonFileAccessModel->read();
                ?>
                <p class="trans_lang"><strong><?=strtoupper($lang);?></strong></p>
                <textarea name="translation_text_<?=$lang;?>" class="translation-text" readonly><?=$data;?></textarea>
            <?php } ?>

            <div class="form-row">
                <div class="form-column">
                    <label>
                        Статус задания:
                    </label>
                    <label class="label-status"><input type="radio" name="status" value="done" required />Выполнено</label>
                    <label class="label-status"><input type="radio" name="status" value="rejected" required />На доработку</label>
                    <label class="label-status"><input type="radio" name="status" value="" required />Не менять статус</label>
                </div>
                <div>
                    <button>Сохранить</button>
                </div>
            </div>
        </form>
    </div>
    

</div>
