<?php
/**
 * media model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Media_Model {

    private $db;
    private $table;
    private $table_sort;

    function __construct() {
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'attachment';
        $this->table_sort = DB_PREFIX . 'media_sort';
    }

    function getMedias($page = 1, $perpage_count = 24, $uid = 0, $sid = 0, $dateTime = '') {
        $startId = ($page - 1) * $perpage_count;
        $author = $uid ? 'and author=' . $uid : '';
        $sort = $sid ? 'and sortid=' . $sid : '';
        $date = $dateTime ? 'and addtime <= ' . strtotime($dateTime) : '';
        $limit = "LIMIT $startId, " . $perpage_count;

        $sql = "SELECT * FROM $this->table m LEFT JOIN $this->table_sort s ON m.sortid=s.id WHERE m.thumfor = 0 $author $sort $date order by m.aid desc $limit";
        $query = $this->db->query($sql);
        $medias = [];
        while ($row = $this->db->fetch_array($query)) {
            $medias[$row['aid']] = [
                'attsize'       => changeFileSize($row['filesize']),
                'filename'      => htmlspecialchars($row['filename']),
                'addtime'       => date("Y-m-d H:i:s", $row['addtime']),
                'aid'           => $row['aid'],
                'filepath_thum' => $row['filepath'],
                'filepath'      => str_replace("thum-", '', $row['filepath']),
                'width'         => $row['width'],
                'height'        => $row['height'],
                'mimetype'      => $row['mimetype'],
                'author'        => $row['author'],
                'sortid'        => $row['sortid'],
                'sortname'      => htmlspecialchars(isset($row['sortname']) ? $row['sortname'] : ''),
            ];
        }
        return $medias;
    }

    function getMediaCount($uid = null, $sid = null, $dateTime = '') {
        $author = $uid ? 'and author=' . $uid : '';
        $sort = $sid ? 'and sortid=' . $sid : '';
        $date = $dateTime ? 'and addtime<=' . strtotime($dateTime) : '';
        $sql = "SELECT count(*) as count FROM $this->table WHERE thumfor = 0 $author $sort $date";
        $res = $this->db->once_fetch_array($sql);
        return $res['count'];
    }

    function addMedia($file_info, $sortid, $uid = UID) {
        $file_name = $file_info['file_name'];
        $file_size = $file_info['size'];
        $file_path = $file_info['file_path'];
        $file_mime_type = $file_info['mime_type'];
        $img_width = $file_info['width'];
        $img_height = $file_info['height'];
        $create_time = time();

        if (isset($file_info['thum_file'])) {
            $file_path = $file_info['thum_file'];
        }

        $query = "INSERT INTO $this->table (author, sortid, filename, filesize, filepath, addtime, width, height, mimetype, thumfor)
                  VALUES('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
        $query = sprintf($query, $uid, $sortid, $file_name, $file_size, $file_path, $create_time, $img_width, $img_height, $file_mime_type, 0);
        $this->db->query($query);
        return $this->db->insert_id();
    }

    function deleteMedia($media_id) {
        $author = User::haveEditPermission() ? '' : 'and author=' . UID;
        $query = $this->db->query("SELECT * FROM $this->table WHERE aid = $media_id $author");
        $attach = $this->db->fetch_array($query);
        if (empty($attach)) {
            return;
        }
        $filepath_thum = $attach['filepath'];
        $filepath = str_replace("thum-", "", $attach['filepath']);
        if (file_exists($filepath_thum)) {
            @unlink($filepath_thum) or emMsg("删除失败!");
        }
        if (file_exists($filepath)) {
            @unlink($filepath) or emMsg("删除失败!");
        }

        return $this->db->query("DELETE FROM $this->table WHERE aid = $media_id $author");
    }

    function updateMedia($data, $media_id) {
        $author = User::haveEditPermission() ? '' : 'and author=' . UID;
        $Item = [];
        foreach ($data as $key => $val) {
            $Item[] = "$key='$val'";
        }
        $upStr = implode(',', $Item);
        $this->db->query("UPDATE $this->table SET $upStr WHERE aid=$media_id $author");
    }

}
