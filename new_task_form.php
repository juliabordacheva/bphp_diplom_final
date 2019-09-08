<?php
$filter_param = isset($_GET['filter']) ? "?filter=" . $_GET['filter'] : "";
?>

<div class="container">
    <div class="row">
        <div class="form_wrapper">
            <div class="button_close"><a href="index.php<?=$filter_param;?>">Закрыть</a></div>
            <form action="index.php?create=true" enctype="multipart/form-data" method="POST">
                <div class="form_wrapper_1">
                    <?php
                    $jsonFileAccessModel = new JsonFileAccessModel('allUsers');
                    $users = json_decode($jsonFileAccessModel->read(), true);
                    $translators = array_filter($users, function ($user) {
                        return $user['status'] == 'translator';
                    });
                    ?>
                    <label>
                        Ответственный:
                        <select name="translator">
                            <option value="">Переводчики</option>
                            <?php
                            foreach ($translators as $translator) {
                                $tasks_num = $tasksList->getTasksNum($translator['email']);
                                $selected = ($task['translator'] == $translator['email']) ? 'selected' : '';
                                echo '<option value="' . $translator['email'] . '"' . $selected . '>' . $translator['name'] . ' (' . $tasks_num . ')' . '</option>';
                            }
                            ?>
                        </select>
                    </label>
                    <label>
                        Клиент:
                        <input type="text" name="client" value="" placeholder="ООО Строймаш">
                    </label>
                </div>

                <div class="form_wrapper_2">
                    <?php
                    $jsonFileAccessModel2 = new JsonFileAccessModel('languages');
                    $languages = json_decode($jsonFileAccessModel2->read(), true);
                    ?>
                    <label>
                        Язык оригинала: <br>
                        <?php
                        foreach ($languages as $value) {
                            echo '<label><input  type="radio" name="ref_lang" value="' . $value['id'] . '" required />' . $value['name'] . '</label>';
                        }
                        ?>
                    </label>
                </div>

                <div class="form_wrapper_3">
                    <label>
                        Языки перевода: <br>
                        <?php
                        foreach ($languages as $key => $value) {
                            echo '<label><input type="checkbox" name="trans_lang[' . $key . ']" value="' . $value['id'] . '" />' . $value['name'] . '</label>';
                        }
                        ?>
                    </label>
                </div>
                <textarea name="text"  placeholder="Внесите сюда текст"></textarea>

                <div class="form_wrapper_4">


                        <label>
                            Крайний срок
                            <input type="date" name="deadline" required/>
                        </label>
                    <button>Сохранить</button>

                </div>
            </form>
        </div>
    </div>


</div>
