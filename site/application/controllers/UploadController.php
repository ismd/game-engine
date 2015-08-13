<?php
/**
 * Контроллер загрузок
 * @author ismd
 */

require APPLICATION_PATH . '/../lib/ImageResize.php';
use \Eventviva\ImageResize;

class UploadController extends PsController {

    const AVATAR_UPLOAD_PATH         = APPLICATION_PATH . '/../public/pictures/avatars';
    const AVATAR_UPLOAD_RESIZED_PATH = APPLICATION_PATH . '/../public/pictures/avatars_resized';

    public function avatarAction() {
        if ($_FILES['file']['error'] != UPLOAD_ERR_OK) {
            $this->view->json([
                'status' => 'error',
            ]);
        }

        $microtime  = microtime(true);
        $microtime  = (int)str_replace('.', '', $microtime);
        $microtime /= rand(10000, 100000);
        $microtime  = (int)$microtime;

        $tmpName = $_FILES['file']['tmp_name'];

        // Расширение
        switch ($_FILES['file']['type']) {
        case 'image/jpeg':
            $extension = 'jpg';
            break;

        case 'image/png':
            $extension = 'png';
            break;

        case 'image/gif':
            $extension = 'gif';
            break;

        default:
            $this->view->json([
                'status' => 'error',
            ]);
            break;
        }

        // Имя файла
        $i = 0;
        do {
            if (100 == $i++) {
                $this->view->json([
                    'status' => 'error',
                ]);

                throw new Exception('Error while uploading file');
            }

            $name = $this->getHelper('generator')->alphaID($microtime);

            if (!file_exists(self::AVATAR_UPLOAD_PATH . '/' . $name . '.' . $extension)) {
                break;
            }
        } while (true);

        if (!is_dir(self::AVATAR_UPLOAD_PATH)) {
            mkdir(self::AVATAR_UPLOAD_PATH, 0700);
        }

        if (!is_dir(self::AVATAR_UPLOAD_RESIZED_PATH)) {
            mkdir(self::AVATAR_UPLOAD_RESIZED_PATH, 0700);
        }

        move_uploaded_file($tmpName, self::AVATAR_UPLOAD_PATH . '/' . $name . '.' . $extension);
        chmod(self::AVATAR_UPLOAD_PATH . '/' . $name . '.' . $extension, 400);

        $this->resizeImage(self::AVATAR_UPLOAD_PATH,
                           self::AVATAR_UPLOAD_RESIZED_PATH,
                           $name,
                           $extension);

        $this->view->json([
            'status' => 'ok',
            'image'  => $name . '.' . $extension,
        ]);
    }

    private function resizeImage($path, $resizedPath, $name, $extension) {
        $image = new ImageResize($path . '/' . $name . '.' . $extension);
        $image->crop(120, 120);
        $image->save($resizedPath . '/120x120_' . $name . '.' . $extension);
        chmod($resizedPath . '/120x120_' . $name . '.' . $extension, 400);
    }
}
