<?php

class M_Users
{
    private $sqlite;
    private $sid;
    private $uid;
    private $onlineMap;

    public function __construct()
    {
        $this->sqlite = new M_SQLite3();
        $this->sid = null;
        $this->uid = null;
        $this->onlineMap = null;
    }

    function __get(string $name)
    {
        if ($name == "sid")
            return $this->sid;
        throw new Exception("Unknown property!");
    }

    public function ClearSessions()
    {
        $min = time() - 60 * 20;
        $where = "last_action < '$min'";
        $this->sqlite->Delete('sessions', $where);
    }

    /**
     * @param array $udata
     * @param $link
     * @return bool
     */
    public function Register(array $udata, &$link)
    {
        $user = $this->GetByLogin($udata['login']);
        if ($user) {
            $link = $user['login'];
            return false;
        }
        $udata['password'] = password_hash($udata['password'], PASSWORD_BCRYPT);
        if (!$this->sqlite->Insert('users', $udata))
            return false;
        $uid = $this->sqlite->db->lastInsertRowID();
        $this->sid = $this->OpenSession($uid);
        return true;
    }

    /**
     * @param string $login
     * @param string $password
     * @param bool $remember
     * @return bool
     */
    public function Login(string $login, string $password, bool $remember = false)
    {
        $user = $this->GetByLogin($login);
        if (!$user || !password_verify($password, $user['password']))
            return false;
        if ($remember) {
            $expire = time() + 3600 * 24 * 100;
            $udata = array('login' => $login, 'password' => $user['password']);
            setcookie('udata', serialize($udata), $expire);
        }
        $this->sid = $this->OpenSession((int)$user['id_user']);
        return true;
    }

    /**
     * @param string $login
     * @return array|bool
     */
    public function GetByLogin(string $login)
    {
        $login = $this->sqlite->escape($login);
        $query = "SELECT * FROM users WHERE login = '$login'";
        return $this->sqlite->SelectOne($query);
    }

    /**
     * @param int $id_user
     * @return string
     */
    private function OpenSession(int $id_user)
    {
        $sid = $this->randomStr(10);
        $now = time();
        $session = array();
        $session['id_user'] = $id_user;
        $session['sid'] = $sid;
        $session['time_start'] = $now;
        $session['last_action'] = $now;
        $this->sqlite->Insert('sessions', $session);
        $_SESSION['sid'] = $sid;
        return $sid;
    }

    /**
     * @param int $outLength
     * @param string $abd
     * @return string
     */
    public function randomStr(int $outLength = 21, string $abd = '')
    {
        $s = '';
        $abd = $abd ?: implode(range('A', 'Z')) . implode(range('a', 'z')) . implode(range('0', '9'));
        $abd_length = mb_strlen($abd) - 1;
        while (mb_strlen($s) < $outLength)
            $s .= $abd[mt_rand(0, $abd_length)];
        return $s;
    }

    public function Logout()
    {
        setcookie('udata', '', time() - 1);
        unset($_COOKIE['udata']);
        $this->sid = null;
        $this->uid = null;
    }

    /**
     * @param int $id_user
     * @return bool
     */
    public function getById(int $id_user = 0)
    {
        $id_user = $id_user ?: $this->GetUid();
        if (!$id_user)
            return false;
        $query = "SELECT * FROM users WHERE id_user = '$id_user'";
        return $this->sqlite->SelectOne($query);
    }

    /**
     * @return int|null
     */
    public function GetUid()
    {
        if ($this->uid != null)
            return $this->uid;
        $sid = $this->GetSid();
        if ($sid == null)
            return null;
        $sid = $this->sqlite->escape($sid);
        $query = "SELECT id_user FROM sessions WHERE sid = '$sid'";
        $result = $this->sqlite->SelectOne($query, false);
        $this->uid = $result ?: null;
        return (int)$this->uid;
    }

    /**
     * @return null|string
     */
    private function GetSid()
    {
        if ($this->sid != null)
            return $this->sid;
        $sid = $_SESSION['sid'];
        if ($sid != null) {
            $session = array();
            $session['last_active'] = time();
            $csid = $this->sqlite->escape($sid);
            $where = "sid = '$csid'";
            $result = $this->sqlite->Update('sessions', $session, $where);

            if (!$result) {
                $query = "SELECT count(*) FROM sessions WHERE sid = '$csid'";
                if ($this->sqlite->SelectOne($query, false) == 0)
                    $sid = null;
            }
        }
        if ($sid == null && isset($_COOKIE['udata'])) {
            $udata = unserialize($_COOKIE['udata']);
            $user = $this->GetByLogin($udata['login']);
            if ($user != null && $user['password'] == $udata['password'])
                $sid = $this->OpenSession($user['id_user']);
        }
        $this->sid = $sid ?: null;
        return $sid;
    }

    /**
     * @param string $permission
     * @param int $id_user
     * @return bool
     */
    public function Can(string $permission, int $id_user = 0)
    {
        if (!$id_user)
            $id_user = $this->GetUid();
        if (!$id_user)
            return false;
        $permission = $this->sqlite->escape($permission);
        $query = "SELECT count(*) FROM permissions_to_roles p2r
			  LEFT JOIN users u ON u.id_role = p2r.id_role
			  LEFT JOIN permissions p ON p.id_permission = p2r.id_permission 
			  WHERE u.id_user = '$id_user' AND p.title_permission= '$permission'";
        return (bool)$this->sqlite->SelectOne($query, false);
    }

    /**
     * @param int $id_user
     * @return bool
     */
    public function IsOnline(int $id_user)
    {
        if ($this->onlineMap == null) {
            $query = "SELECT DISTINCT id_user FROM sessions";
            $result = $this->sqlite->Select($query);
            foreach ($result as $item)
                $this->onlineMap[$item['id_user']] = true;
        }
        return ($this->onlineMap[$id_user . ''] != null);
    }


}