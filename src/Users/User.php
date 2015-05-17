<?php
namespace Anax\Users;

/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{
    
    /**
     * Login user
     *
     * @param array $credentials with acronym and password
     *
     * @return object $user
     */
    public function login($credentials)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where("acronym = ?");
                 
        $this->db->execute([$credentials['acronym']]);
        $user = $this->db->fetchInto($this);
        
        if(password_verify($credentials['password'], $user->password))
        {
            if($user->acronym == 'admin')
            {
                $this->session->set('admin', true);
            }
            $this->session->set('user', $user->id);
            return $user;
        }
    }
    
    /**
     * Logout user (Doesn't really have anything to do with the user model)
     *
     * @return void
     */
    public function logout()
    {
        if($this->session->has('user'))
        {
            $this->session->set('user', null);
        }
        if($this->session->has('admin'))
        {
            $this->session->set('admin', null);
        }
        
    }
    
    /**
     * Find all users
     *
     * @return objects
     */
    public function findAll()
    {
        $this->db->select('u.id, u.acronym, COUNT(q.id) counter')
                 ->from($this->getSource() . ' AS u')
                 ->leftJoin('question AS q', 'u.id = q.userId')
                 ->groupby('u.id');
                 
        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
    
    /**
     * Find most avtive users
     *
     * @param int $limit
     *
     * @return objects
     */
    public function findMostActive($limit)
    {
        $prefix = $this->db->getTablePrefix();
        
        $sql = "SELECT u.id, u.acronym, sum(n) counter 
                    FROM {$prefix}{$this->getSource()} as u
                        LEFT OUTER JOIN
                        (
                        SELECT userId as id, COUNT(*) n FROM {$prefix}question GROUP by id
                        UNION ALL
                        SELECT userId as id, COUNT(*) FROM {$prefix}answer GROUP by id
                        UNION ALL
                        SELECT userId as id, COUNT(*) FROM {$prefix}comment GROUP BY id
                        ) x	ON u.id = x.id
                GROUP BY u.id
                ORDER BY counter DESC
                LIMIT {$limit};";
                
        $this->db->execute($sql);         
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
    
}