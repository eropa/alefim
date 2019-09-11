<?php


function image_create($image_path) {

    $ext = pathinfo($image_path, PATHINFO_EXTENSION);
    switch($ext) {
        case 'gif':
            $im = imagecreatefromgif($image_path);
            break;
        case 'jpg':
            $im = imagecreatefromjpeg($image_path);
            break;
        case 'png':
            $im = imagecreatefrompng($image_path);
            break;
        default:
            throw new Exception('Неверный формат файла');
    }

    unset($ext);
    return $im;
}

function image_crop($image_source, $save_as, $x, $y, $width, $height) {

    // Проверка на наличие изображений
    if (!file_exists($image_source)) { throw new Exception('Изображение '.$image_source.' не найдено'); }


    // формируем картинки для работы
    $im = image_create($image_source);
    $new_image_right = imagecreatetruecolor($width, $height);
    $new_image_left = imagecreatetruecolor($width, $height);
    $image = imagecreatetruecolor($width*2, $height);

    // чтобы показать картинку
    header('Content-Type: image/png');

    //получаем правую часть до зеркальной
    imagecopy($new_image_right, $im, 0, 0, $x, $y, $width, $height);
    // делаем по зеркалу отражение
    imageflip($new_image_right, IMG_FLIP_HORIZONTAL);
    // получаем правую
    imagecopy($new_image_left, $im, 0, 0, $x, $y, $width, $height);

    // сойденяем пока одну часть
    imagecopy($image, $new_image_left, 0, 0, 0, 0, 444, 444);
    // сойденяем другую часть
    imagecopy($image, $new_image_right,$width, 0, 0, 0, 444, 444);
    // сохранение картинки
    imagepng($image, $save_as);

    // показываем
    imagepng($image);
    //чистим
    imagedestroy($im);
    imagedestroy($image);
    imagedestroy($new_image_right);
    imagedestroy($new_image_left);
}



    //Оригинал качаем себе
    $link = "https://pngicon.ru/file/uploads/vinni-pukh-v-png-256x256.png";
    $file = file_get_contents($link);
    $name=time().".png";
    file_put_contents($name, $file);

    // получаем размеры
    list($width, $height) = getimagesize($name);
    $newwidth=$width*0.5;

    // Cоздаем картинку новую как в задании
    image_crop($name, '_new_image'.$name, 0, 0, $newwidth, $height);