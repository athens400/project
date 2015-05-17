<?php
namespace Anax\QA;

/**
 * Model for Questions extends base model CDatabaseModel.
 *
 */
class Question extends \Anax\MVC\CDatabaseModel
{
    
    /**
     * Find question matching slug
     *
     * @param string $slug to find
     *
     * @return void
     */
    
    public function findWithOwner($id)
    {
        $this->db->select('q.*, u.acronym')
                 ->from($this->getSource() . " AS q")
                 ->leftJoin('user AS u', 'q.userId = u.id')
                 ->where("q.id = ?");
 
        $this->db->execute([$id]);
        return $this->db->fetchInto($this);
    }
    
    public function findLatest($limit = null)
    {
        $this->db->select('DISTINCT q.*, COUNT(DISTINCT a.id) AS answers, GROUP_CONCAT(DISTINCT t.tag) AS tags')
                 ->from($this->getSource() . ' AS q')
                 ->leftJoin('answer AS a', 'q.id = a.qId')
                 ->leftJoin('question2tag AS q2t', 'q.id = q2t.idQuestion')
                 ->leftJoin('tag AS t', 'q2t.idTag = t.id')
                 ->groupby('q.id, a.qId')
                 ->orderby('q.id DESC');
        if(!is_null($limit) && !empty($limit))
        {
        $this->db->limit($limit);
        }

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        $result = $this->db->fetchAll();
        
        return $result;
    }
    
    /**
     * Find questions with most answers
     *
     * @param int $limit
     *
     * @return objects
     */
    public function findAnswered($limit = null)
    {
        $this->db->select('DISTINCT q.*, COUNT(DISTINCT a.id) AS answers, GROUP_CONCAT(DISTINCT t.tag) AS tags')
                 ->from($this->getSource() . ' AS q')
                 ->leftJoin('answer AS a', 'q.id = a.qId')
                 ->leftJoin('question2tag AS q2t', 'q.id = q2t.idQuestion')
                 ->leftJoin('tag AS t', 'q2t.idTag = t.id')
                 ->groupby('q.id, a.qId')
                 ->orderby('answers DESC');
        if(!is_null($limit) && !empty($limit))
        {
        $this->db->limit($limit);
        }

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        $result = $this->db->fetchAll();
        
        return $result;
    }
    
    /**
     * Find questions with tag
     *
     * @param string $tag
     *
     * @return objects
     */
    public function findWhereTag($tag)
    {
        $this->db->select('DISTINCT q.*, COUNT(DISTINCT a.id) AS answers, GROUP_CONCAT(DISTINCT t.tag) AS tags')
                 ->from($this->getSource() . ' AS q')
                 ->leftJoin('answer AS a', 'q.id = a.qId')
                 ->leftJoin('question2tag AS q2t', 'q.id = q2t.idQuestion')
                 ->leftJoin('tag AS t', 'q2t.idTag = t.id')
                 ->where('t.tag = ?')
                 ->groupby('q.id, a.qId')
                 ->orderby('q.id DESC');
                 
        $this->db->execute([$tag]);
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
    
    public function findWhereUserId($userId = null)
    {
        $this->db->select('DISTINCT q.*, COUNT(DISTINCT a.id) AS answers, GROUP_CONCAT(DISTINCT t.tag) AS tags')
                 ->from($this->getSource() . ' AS q')
                 ->leftJoin('answer AS a', 'q.id = a.qId')
                 ->leftJoin('question2tag AS q2t', 'q.id = q2t.idQuestion')
                 ->leftJoin('tag AS t', 'q2t.idTag = t.id')
                 ->where('q.userId = ?')
                 ->groupby('q.id, a.qId')
                 ->orderby('answers DESC');

        $this->db->execute([$userId]);
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
    
}