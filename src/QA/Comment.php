<?php
namespace Anax\QA;

/**
 * Model for Comments.
 *
 */
class Comment extends \Anax\MVC\CDatabaseModel
{
    
    /**
     * Find all comments for question or answer
     *
     * @param int $qId
     * @param int $aId
     *
     * @return objects
     */
    public function findAll($qId = null, $aId = null)
    {
        $this->db->select('c.*, u.acronym')
                 ->from($this->getSource() . ' AS c')
                 ->leftJoin('user AS u', 'c.userId = u.id')
                 ->where("c.qId = ?")
                 ->andWhere("c.aId = ?");
 
        $this->db->execute([$qId, $aId]);
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
    
    /**
     * Delete comment
     *
     * @param mixed $param value
     * @param string $col column
     *
     * return bool
     */
    public function delete($param = null, $col = 'id')          // Default unnecessary but for clarities sake
    {
        $col = is_null($col) ? 'id' : $col;
        $this->db->delete(
            $this->getSource(),
            "$col = ?"
        );
 
        return $this->db->execute([$param]);
    }    
}