<?php
require_once 'composer/vendor/autoload.php';
use Google\Cloud\Storage\StorageClient;

class setUploadGcs {

	const PROJECT_ID = 'uc-kimachi';
	const GOOGLE_APPLICATION_CREDENTIALS = '/etc/cloud_sql_proxy/UCkimachi-6fe52f3516c3.json';
	const GOOGLE_GCS_URL = 'https://storage.googleapis.com/';
	const BUCKET_NAME = 'hachiman-storage';
	const TMP_FILE = '/var/cache/gcp/tmp.jpg';

	public function __construct() {

		$this->_storage = new StorageClient([
			'projectId' => self::PROJECT_ID,
			'keyFile' => json_decode(file_get_contents(self::GOOGLE_APPLICATION_CREDENTIALS), true),
		]);

		$this->_bucket = $this->_storage->bucket(self::BUCKET_NAME);
		$this->_sizes = ['', '640', '600', '320', '300', '160', '125', '80', '64'];

	}
	public function __destruct() { /* デストラクタ */}

	private $_upfile;
	private $_filename;
	private $_upload_path;
	private $_sizes;
	private $_item_id;
	private $_tbl_image;
	private $_pfx;
	private $_tbl;
	private $_storage;
	private $_bucket;
	private $_ajax;

	public function get_filename() {return $this->_filename;}

	public function set_filename($_filename) {$this->_filename = $_filename;}
	public function set_upfile($_upfile) {$this->_upfile = $_upfile;}
	public function set_upload_path($_upload_path) {$this->_upload_path = $_upload_path;}
	public function set_sizes($_sizes) {$this->_sizes = $_sizes;}
	public function set_item_id($_item_id) {$this->_item_id = $_item_id;}
	public function set_tbl_image($_tbl_image) {$this->_tbl_image = $_tbl_image;}
	public function set_tbl($_tbl) {$this->_tbl = $_tbl;}
	public function set_pfx($_pfx) {$this->_pfx = $_pfx;}
	public function set_ajax($_ajax) {$this->_ajax = $_ajax;}

	public function existfile() {
		try {
			$object = $this->_bucket->object($this->_filename);
		} catch (Exception $e) {
			return false;
		}
		return $object->exists();
	}

	public function execRawUpload() {
		$upload_path = $this->_upload_path;

		$file = fopen($this->_upfile, 'r');

		try {
			$upload_filename = basename($this->_upfile);
			$object = $this->_bucket->upload($file, [
				'name' => $upload_path . $upload_filename,
			]);

			@unlink($this->_upfile);
		} catch (Exception $e) {
			throw new Exception("ファイルのアップロードに失敗しました。", 1);
		}

	}

	public function execUpload() {

		global $smarty, $pdo, $pfx2;
		$filename = $this->_filename;
		$upload_path = $this->_upload_path;
		$sizes = $this->_sizes;
		$upfile = $this->_upfile;

		try {

			$image = new Imagick(); // phpでImageMagick使います
			$image->setresolution(144, 144);
			$image->readImage($upfile);

			$page_count = $image->getImageScene();
			if ($page_count > 0) {
				$image->setIteratorIndex(0);
			}
			$fileinfo = $image->identifyImage();

// jpg以外の場合jpgに変換
			if (!preg_match('/JPEG/', $fileinfo['format'])) {
				$image->setImageBackgroundColor('white');
				$image->setImageFormat("jpg");
				$image->setImageAlphaChannel(imagick::ALPHACHANNEL_DEACTIVATE);
			}

			$filename = md5(time() . $fileinfo['imageName']);

//			$image->writeImage($upload_path . $filename . '.jpg');

			foreach ($sizes as $size) {

				if ($size === "") {

				} else if ($size <= "80") {
					//正方形サムネイル作成
					$image->cropThumbnailImage($size, $size);
				} else if ($size <= "125") {
					// 125x98サムネイル作成

					if ($image->getImageWidth() > $image->getImageHeight()) {

						$image->resizeImage($size, 0, Imagick::FILTER_LANCZOS, 1);
						$image->setImageBackgroundColor(new ImagickPixel('white'));

						$height = (98 - $image->getImageHeight());
						if ($height < 0) {$height = 0;}
						$image->spliceImage(0, intval($height / 2), 0, 0);

						$image->spliceImage(0, $height / 2, 0, intval($image->getImageHeight()));

					} else {
						$image->resizeImage(0, 98, Imagick::FILTER_LANCZOS, 1);
						$image->setImageBackgroundColor(new ImagickPixel('white'));
						$width = ($size - $image->getImageWidth());
						if ($width < 0) {$width = 0;}
						$image->spliceImage(intval($width) / 2, 0, 0, 0);
						$image->spliceImage($width / 2, 0, intval($image->getImageWidth()), 0);
					}

				} else if ($size <= "160") {
					// 160x125サムネイル作成

					if ($image->getImageWidth() > $image->getImageHeight()) {

						$image->resizeImage($size, 0, Imagick::FILTER_LANCZOS, 1);
						$image->setImageBackgroundColor(new ImagickPixel('white'));

						$height = (125 - $image->getImageHeight());
						if ($height < 0) {$height = 0;}
						$image->spliceImage(0, intval($height) / 2, 0, 0);

						$image->spliceImage(0, $height / 2, 0, intval($image->getImageHeight()));

					} else {
						$image->resizeImage(0, 160, Imagick::FILTER_LANCZOS, 1);
						$image->setImageBackgroundColor(new ImagickPixel('white'));
						$width = ($size - $image->getImageWidth());
						if ($width < 0) {$width = 0;}
						$image->spliceImage(intval($width) / 2, 0, 0, 0);
						$image->spliceImage($width / 2, 0, intval($image->getImageWidth()), 0);
					}

				} else {
					$image->resizeImage($size, 0, Imagick::FILTER_LANCZOS, 1);
				}

				$image->writeImage(self::TMP_FILE);
				$file = fopen(self::TMP_FILE, 'r');

				$upload_filename = $this->setFilename($size, $filename);

				$object = $this->_bucket->upload($file, [
					'name' => $upload_filename,
				]);

				@unlink(self::TMP_FILE);
//				$image->writeImage($upload_path . $size . '_' . $filename . '.jpg');

			}

		} catch (ImagickException $e) {
			$smarty->assign('page_title', 'エラー');
			$smarty->assign('errmsg', 'ファイルの種類が不正です。' . $e->getMessage());
			if (!$this->_ajax) {
				$smarty->display('error.tpl');
				exit();
			}
		} catch (Exception $e) {
			$smarty->assign('page_title', 'エラー');
			$smarty->assign('errmsg', '画像の変換に失敗しました。');
			if (!$this->_ajax) {
				$smarty->display('error.tpl');
				exit();
			}
		}

		if (!$filename) {return;}
		$this->_filename = $filename . '.jpg';

// 商品を編集した場合は、既存の画像を削除する
		$this->deleteImage();

	}

	private function setFilename($s, $f) {

		if ($s) {
			$upload_filename = $this->_upload_path . $s . '_' . $f . '.jpg';
		} else {
			$upload_filename = $this->_upload_path . $f . '.jpg';
		}
		return $upload_filename;
	}

	private function deleteObject($object) {
		try {
			$object = $this->_bucket->object($object);
			$object->delete();
		} catch (Exception $e) {
		}
	}

	private function getImageName() {
		global $smarty, $pdo, $pfx2;

		$tbl = $this->_tbl;
		// 既存の画像のファイル名を得る
		$sql = "SELECT ";

		$tmp = [];
		foreach ($this->_tbl_image as $img) {
			array_push($tmp, '`' . $img . '`');
		}

		if (count($tmp)) {
			$sql .= implode(',', $tmp);

		}

		$this->_pfx2 = $pfx2;

		if ($this->_pfx) {
			$this->_pfx2 = $this->_pfx;
		}

		$sql .= " FROM {$this->_pfx2}${tbl} WHERE id = ?";

		$data = array(intval($this->_item_id));
		try {
			$res = $pdo->prepare($sql);
			$res->execute($data);
			$data = $res->fetch();
		} catch (PDOException $e) {
			$smarty->assign('page_title', 'エラー');
			$smarty->assign('errmsg', '画像名の取得に失敗しました。');
			if (!$this->_ajax) {
				$smarty->display('error.tpl');
				exit();
			}
		}

		return $data;
	}

	private function updateImageNameNull() {
		global $smarty, $pdo, $pfx2;

		$this->_pfx2 = $pfx2;

		if ($this->_pfx) {
			$this->_pfx2 = $this->_pfx;
		}

		$sql = "UPDATE {$this->_pfx2}$this->_tbl SET ";

		$tmp = [];
		foreach ($this->_tbl_image as $img) {
			array_push($tmp, '`' . $img . '` = null');
		}

		if (count($tmp)) {
			$sql .= implode(',', $tmp);

		}

		$sql .= " WHERE id = ?";

		$data = array($this->_item_id);
		try {
			$res = $pdo->prepare($sql);
			$res->execute($data);
		} catch (PDOException $e) {
			$smarty->assign('page_title', 'エラー');
			$smarty->assign('errmsg', '商品画像の削除に失敗しました。');
			if (!$this->_ajax) {
				$smarty->display('error.tpl');
				exit();
			}
		}
	}

	public function execDeleteImage() {

		$this->deleteImage();
		$this->updateImageNameNull();
	}

	public function execDeleteImageOnly() {

		$this->deleteImage();
	}

	private function deleteImage() {

		if ($this->_item_id) {

			$data = $this->getImageName();
			foreach ($this->_tbl_image as $k => $img) {
				if ($data[$img]) {
					$data[$img] = preg_replace('/\.jpg$/', '', $data[$img]);
					if (count($this->_sizes)) {
						foreach ($this->_sizes as $size) {

							$upload_filename = $this->setFilename($size, $data[$img]);

							$this->deleteObject($upload_filename);
						}
					}
				}
			}
		}
	}

}
?>
