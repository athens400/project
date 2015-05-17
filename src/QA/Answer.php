<?php
namespace Anax\QA;

/**
 * Model for Answers extends base model CDatabaseModel.
 *
 */
class Answer extends \Anax\MVC\CDatabaseModel
{
    
    /**
     * Find all answers with question id
     *
     * @param int $questionId for matching answers
     *
     * @return objects
     */
    public function findAll($qId = null)
    {
        $this->db->select('a.*, u.acronym')
                 ->from($this->getSource() . ' AS a')
                 ->leftJoin('user AS u', 'a.userId = u.id')
                 ->where("a.qId = ?");
 
        $this->db->execute([$qId]);
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
    
    /**
     * Delete answers based on question id
     *
     * @return bool
     */
    public function deleteWhereQuestionId($qId)     // Obsolete
    {
        $this->db->delete(
            $this->getSource(),
            'qId = ?'
        );
 
        return $this->db->execute([$qId]);
    }
    
    /**
     * Delete answer
     *
     * @param mixed $param value
     * @param string $col column
     *
     * @return bool
     */
    public function delete($param = null, $col = 'id')     // Default unnecessary but for clarities sake...
    {
        $col = is_null($col) ? 'id' : $col;
        $this->db->delete(
            $this->getSource(),
            "{$col} = ?"
        );
 
        return $this->db->execute([$param]);
    }  
    
}