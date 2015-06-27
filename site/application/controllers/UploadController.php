<?php
/**
 * Контроллер загрузок
 * @author ismd
 */

class UploadController extends PsController {

    const UPLOAD_PATH = APPLICATION_PATH . '/../public/pictures/avatar';

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
            $extension = '.jpg';
            break;

        case 'image/png':
            $extension = '.png';
            break;

        case 'image/gif':
            $extension = '.gif';
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

            $name = $this->getHelper('generator')->alphaID($microtime) . $extension;

            if (!file_exists(self::UPLOAD_PATH . '/' . $name)) {
                break;
            }
        } while (true);

        move_uploaded_file($tmpName, self::UPLOAD_PATH . '/' . $name);

        $this->view->json([
            'status' => 'ok',
            'image'  => $name,
        ]);
    }
}
