<?php




/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['full_name'] = !empty($_COOKIE['fio_error']);
  $errors['phone'] = !empty($_COOKIE['phone_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['birth_date'] = !empty($_COOKIE['birth_date_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['agreement'] = !empty($_COOKIE['agreement_error']);
  $errors['languages'] = !empty($_COOKIE['languages_error']);
  $errors['submit'] = !empty($_COOKIE['submit_error']);
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['fio']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('fio_error', '', 100000);
    setcookie('fio_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['phone']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('phone_error', '', 100000);
    setcookie('phone_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните номер телефона.</div>';
  }
  if ($errors['email']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    setcookie('email_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните почту.</div>';
  }
  if ($errors['birth_date']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('birth_date_error', '', 100000);
    setcookie('birth_date_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните дату рождения.</div>';
  }
  if ($errors['gender']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('gender_error', '', 100000);
    setcookie('gender_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните пол.</div>';
  }
  if ($errors['biography']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('biography_error', '', 100000);
    setcookie('biography_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните биографию.</div>';
  }
  if ($errors['agreement']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('agreement_error', '', 100000);
    setcookie('agreement_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните согласие.</div>';
  }
  if ($errors['languages']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('languages_error', '', 100000);
    setcookie('languages_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните языки.</div>';
  }
  if ($errors['submit']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('submit_error', '', 100000);
    setcookie('submit_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните языки.</div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['birth_date'] = empty($_COOKIE['birth_date_value']) ? '' : $_COOKIE['birth_date_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  $values['agreement'] = empty($_COOKIE['agreement_value']) ? '' : $_COOKIE['agreement_value'];
  $values['languages'] = empty($_COOKIE['languages_value']) ? '' : $_COOKIE['languages_value'];
  $values['submit'] = empty($_COOKIE['submit_value']) ? '' : $_COOKIE['submit_value'];
  // TODO: аналогично все поля.

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['fio'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['phone'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('phone_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['email'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['birth_date'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('birth_date_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['gender'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['biography'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['agreement'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('agreement_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['languages'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('languages_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['submit'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('submit_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  
// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    setcookie('phone_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('birth_date_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('agreement_error', '', 100000);
    setcookie('languages_error', '', 100000);
    setcookie('submit_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
  }

  // Сохранение в БД.
  // ...

session_start();

$host = 'localhost';
$dbname = 'u82190'; 
$user = 'u82190';   
$pass = '8528410'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $_SESSION['errors']['general'] = "Ошибка подключения к БД: " . $e->getMessage();
    header('Location: index.php');
    exit;
}

$languages = [];
$stmt = $pdo->query("SELECT id, name FROM programming_language ORDER BY id");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $languages[] = $row;
}

$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: index.php');
    exit;
}

$form_data = [
    'fio' => trim($_POST['field-name'] ?? ''),
    'phone' => trim($_POST['field-tel'] ?? ''),
    'email' => trim($_POST['field-email'] ?? ''),
    'birth_date' => $_POST['field-date'] ?? '',
    'gender' => $_POST['radio-group-1'] ?? '',
    'biography' => trim($_POST['field-name-2'] ?? ''),
    'agreement' => isset($_POST['check-1']) ? 1 : 0,
    'languages' => $_POST['listbox'] ?? []
];

try {
    $pdo->beginTransaction();
    
    $gender_db = ($form_data['gender'] == 'Значение1') ? 'male' : 'female';
    
    $sql_app = "INSERT INTO application (fio, phone, email, birth_date, gender, biography, agreement) 
                VALUES (:fio, :phone, :email, :birth_date, :gender, :biography, :agreement)";
    $stmt_app = $pdo->prepare($sql_app);
    $stmt_app->execute([
        ':fio' => $form_data['fio'],
        ':phone' => $form_data['phone'],
        ':email' => $form_data['email'],
        ':birth_date' => $form_data['birth_date'],
        ':gender' => $gender_db,
        ':biography' => $form_data['biography'],
        ':agreement' => $form_data['agreement']
    ]);
    
    $application_id = $pdo->lastInsertId();
    
    $lang_map = [];
    foreach ($languages as $lang) {
        $lang_map[$lang['name']] = $lang['id'];
    }

    $sql_link = "INSERT INTO application_language (application_id, language_id) VALUES (?, ?)";
    $stmt_link = $pdo->prepare($sql_link);
    
    foreach ($form_data['languages'] as $lang_name) {
        if (isset($lang_map[$lang_name])) {
            $stmt_link->execute([$application_id, $lang_map[$lang_name]]);
        }
    }
    
    $pdo->commit();
    
    $_SESSION['success'] = true;
    unset($_SESSION['form_data']);
    unset($_SESSION['errors']);
    
    header('Location: index.php');
    exit;
    
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['errors']['general'] = 'Ошибка сохранения данных: ' . $e->getMessage();
    $_SESSION['form_data'] = $form_data;
    header('Location: index.php');
    exit;
}

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Лабораторная работа 2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <header>
        <img src="https://avatars.mds.yandex.net/i?id=a2c747a3ccfa4d287e074cb7c474dc24c97eb28f-17641277-images-thumbs&n=13" alt="" id="logo" width="100px">
        <nav>
            <a class="link" href="#center">Список ссылок</a>
            <a class="link" href="#tablic">Таблица</a>
            <a class="link" href="#forma">Форма</a>
        </nav>
        <h1 class="name">Лабораторная работа 2</h1>
    </header>

    <div id="center">
        <h2>Список гиперссылок</h2>
        <ul class="list">           
            <li><a class="nav-link" href="http://www.kubsu.ru" title="Официальный сайт КубГУ"> Ссылка на сайт КубГУ первая</a></li>
            <li><a class="nav-link" href="https://www.kubsu.ru" title="Официальный сайт КубГУ"> Ссылка на сайт КубГУ вторая</a></li>
            <li><a class="nav-link" href="https://www.kubsu.ru"><img src="https://avatars.mds.yandex.net/i?id=82b93ff4ec4fc1a0b1e3df7bfdd8a1293bd8eb98-16441608-images-thumbs&n=13" alt="цветочек" style="width: 200px;"></a></li>
            <li><a class="nav-link" href="inside/inside_first.html"> Сокращенная ссылка на внутреннюю страницу</a></li>
            <li><a class="nav-link" href="index.html"> Сокращенная ссылка на главную страницу</a></li>
            <li><a class="nav-link" href="#element"> Ссылка на фрагмент страницы</a></li>
            <li><a class="nav-link" href="index.html?user=123&profile=234&cat=0"> Ссылка с 3 параметрами в URL</a></li>
            <li><a class="nav-link" href="index.html?id=123"> Ссылка с параметром id в URL</a></li>
            <li><a class="nav-link" href="./incatalog.html"> Ссылка на страницу в текущем каталоге</a></li>
            <li><a class="nav-link" href="./about/about.html"> Ссылка на страницу в каталоге about</a></li>
            <li><a class="nav-link" href="../1step.html"> Ссылка на страницу в каталоге уровнем выше</a></li>
            <li><a class="nav-link" href="../../2step.html"> Ссылка на страницу в каталоге двумя уровнями выше</a></li>
            <li class="nav-link">
                 Невероятно осмысленный текст 
                <a class="nav-link" href="https://www.kubsu.ru">со ссылкой</a>
            </li>
            <li><a class="nav-link" href="https://www.kubsu.ru/lib/images/Group3288.png">Ссылка на фрагмент стороннего сайта</a></li>
                
                <img src="https://i.ytimg.com/vi/tqh_z6fugJs/hq720.jpg" width="500px" usemap="#cat">
                <map name="cat">
                    <area shape="rect" coords="0,0,251,274" href="http://www.kubsu.ru">
                    <area shape="circle" coords="400,64,64" href="http://www.kubsu.ru">
                </map>
                
            <li class="nav-link">Ссылки из прямоугольных и круглых областей картинки</li>
            <li><a class="nav-link" href=""> Ссылка с пустым href</a></li>
            <li><a class="nav-link" title="тут ничего нет"> Ссылка без href</a></li>
            <li><a class="nav-link" href="index.html" rel="nofollow"> Ссылка, по которой запрещен переход поисковикам</a></li>  
            <li><noindex><a class="nav-link" href="index.html"> Ссылка, запрещенная для индексации поисковиками</a></noindex></li>
            
            <li>
                <ol class="nav-link">
                    Нумерованный список ссылок
                    <li><a class="nav-link" href="https://www.kubsu.ru" title="Первая">ссылка</a></li>
                    <li><a class="nav-link" href="https://www.kubsu.ru" title="Вторая">ссылка</a></li>
                    <li><a class="nav-link" href="https://www.kubsu.ru" title="Третья">ссылка</a></li>
                </ol>
            </li>
        </ul>
    </div>
    
    <table id="tablic">
        <tr class="chet">
            <th>Первый</th>
            <th>Второй</th>
            <th>Третий</th>
            <th>Четвертый</th>
         </tr>
         <tr class="chet">
            <td colspan="2">ф</td>
            <td>ф</td>
            <td>ф</td>
          </tr>
        <tr class="chet">
            <td rowspan="2">ф</td>
            <td>ф</td>
            <td>ф</td>
            <td>ф</td>
         </tr>
        <tr class="chet">
            <td>ф</td>
            <td>ф</td>
            <td>ф</td>
         </tr>
        <tr class="chet">
            <td>ф</td>
            <td>ф</td>
            <td>ф</td>
            <td>ф</td>
         </tr>
        <tr class="chet">
            <td>ф</td>
            <td>ф</td>
            <td>ф</td>
            <td>ф</td>
         </tr>
        <tr class="chet">
            <td>ф</td>
            <td>ф</td>
            <td>ф</td>
            <td>ф</td>
         </tr>
    </table>
    
    <?php if ($success): ?>
        <div class="success-message">
            Данные успешно сохранены! Спасибо за заполнение анкеты.
        </div>
    <?php endif; ?>
    
    <?php if (!empty($errors) && !isset($errors['general'])): ?>
        <div class="error-summary">
            <strong>Пожалуйста, исправьте следующие ошибки:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($errors['general'])): ?>
        <div class="error-summary">
            <?= htmlspecialchars($errors['general']) ?>
        </div>
    <?php endif; ?>
    
    <form action="form.php" method="POST" id="forma">
        <h3>Форма</h3>
        
        <div class="form-group">
            <label>
                Ваше ФИО
                <br><input name="field-name" placeholder="Введите ФИО" 
                    value="<?= htmlspecialchars($form_data['full_name'] ?? '') ?>"
                    class="<?= isset($errors['field-name']) ? 'error-input' : '' ?>">
                </br>
                <?php if (isset($errors['field-name'])): ?>
                    <span class="error-message"><?= htmlspecialchars($errors['field-name']) ?></span>
                <?php endif; ?>
            </label>
        </div>
        
        <div class="form-group">
            <label>
                Телефон
                <br><input name="field-tel" placeholder="Введите номер телефона" type="tel" 
                    value="<?= htmlspecialchars($form_data['phone'] ?? '') ?>"
                    class="<?= isset($errors['field-tel']) ? 'error-input' : '' ?>">
                </br>
                <?php if (isset($errors['field-tel'])): ?>
                    <span class="error-message"><?= htmlspecialchars($errors['field-tel']) ?></span>
                <?php endif; ?>
            </label>
        </div>
        
        <div class="form-group">
            <label>
                E-mail
                <br><input name="field-email" placeholder="Введите email" type="email" 
                    value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                    class="<?= isset($errors['field-email']) ? 'error-input' : '' ?>">
                </br>
                <?php if (isset($errors['field-email'])): ?>
                    <span class="error-message"><?= htmlspecialchars($errors['field-email']) ?></span>
                <?php endif; ?>
            </label>
        </div>
        
        <div class="form-group">
            <label>
                Дата рождения
                <br><input name="field-date" placeholder="Введите дату рождения" type="date" 
                    value="<?= htmlspecialchars($form_data['birth_date'] ?? '') ?>"
                    class="<?= isset($errors['field-date']) ? 'error-input' : '' ?>">
                </br>
                <?php if (isset($errors['field-date'])): ?>
                    <span class="error-message"><?= htmlspecialchars($errors['field-date']) ?></span>
                <?php endif; ?>
            </label>
        </div>

        <br />
        Пол
        <label><input type="radio" name="radio-group-1" value="Значение1" 
            <?= (($form_data['gender'] ?? '') == 'Значение1') ? 'checked' : '' ?>>Муж</label>
        <label><input type="radio" name="radio-group-1" value="Значение2" 
            <?= (($form_data['gender'] ?? '') == 'Значение2') ? 'checked' : '' ?>>Жен</label>
        <?php if (isset($errors['radio-group-1'])): ?>
            <br><span class="error-message"><?= htmlspecialchars($errors['radio-group-1']) ?></span>
        <?php endif; ?>
        <br/>

        <div class="form-group">
            <label>
                Любимый язык программирования:
                <br>
                <select name="listbox[]" multiple="multiple" 
                    class="<?= isset($errors['listbox']) ? 'error-input' : '' ?>">
                    <?php foreach ($languages as $lang): ?>
                        <?php 
                        $selected = (isset($form_data['languages']) && in_array($lang['name'], $form_data['languages'])) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?= htmlspecialchars($lang['name']) ?>" <?= $selected ?>>
                            <?= htmlspecialchars($lang['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br/>
                <?php if (isset($errors['listbox'])): ?>
                    <span class="error-message"><?= htmlspecialchars($errors['listbox']) ?></span>
                <?php endif; ?>
                <small>Удерживайте Ctrl (Cmd на Mac) для выбора нескольких языков</small>
            </label>
        </div>

        <div class="form-group">
            <label>
                Биография:
                <br>
                <textarea name="field-name-2" 
                    class="<?= isset($errors['field-name-2']) ? 'error-input' : '' ?>"><?= htmlspecialchars($form_data['biography'] ?? 'Расскажите вашу историю') ?></textarea>
                </br>
            </label>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="check-1" value="1" 
                    <?= (($form_data['agreement'] ?? 0) == 1) ? 'checked' : '' ?>>
                С контрактом ознакомлен (а)
                <?php if (isset($errors['check-1'])): ?>
                    <br><span class="error-message"><?= htmlspecialchars($errors['check-1']) ?></span>
                <?php endif; ?>
            </label>
        </div>
        
        <input type="submit" name="submit" value="Сохранить" />
    </form>

    <footer>
        <h2 class="name2">(c)Семерников Никита</h2>
    </footer>
</body>
</html>

