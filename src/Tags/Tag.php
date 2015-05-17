<?php
namespace Anax\Tags;

/**
 * Model for Comments.
 *
 */
class Tag extends \Anax\MVC\CDatabaseModel
{   
    
    private $tagPattern = [
            '/\s/',
            '/^[^a-z0-9åäö]+/ui',
            '/[^a-z0-9åäö]+$/ui',
            '/[^a-z0-9åäö-]/ui'
        ];
        
    private $tagReplace = [
            '-',
            '',
            '',
            ''
        ];

    /**
     * Find all tags
     *
     * @return objects
     */
    public function findAll()
    {
        $this->db->select('t.id, t.tag, COUNT(q.id) counter')
                 ->from($this->getSource() . ' AS t')
                 ->leftJoin('question2tag AS q2t', 't.id = q2t.idTag')
                 ->leftJoin('question AS q', 'q2t.idQuestion = q.id')
                 ->groupby('t.id');
                 
        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
    
    /**
     * Find tags with qId = $qId
     *
     * @param int $qId
     *
     * @return objects
     */
    public function findWhereQId($qId = null)
    {
        $this->db->select()
                 ->from($this->getSource() . " AS t")
                 ->leftJoin("question2tag AS q2t", "t.id = q2t.idTag")
                 ->leftJoin("question AS q", "q.id = q2t.idQuestion")
                 ->where("q2t.idQuestion = ?");
 
        $this->db->execute([$qId]);
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
    
    /**
     * Find most used tags
     *
     * @param int $limit
     *
     * @return objects
     */
    public function findPopular($limit = null)
    {
        $this->db->select('t.*, COUNT(q2t.idTag) AS tagcount')
                 ->from($this->getSource() . " AS t")
                 ->leftJoin('question2tag AS q2t', 't.id = q2t.idTag')
                 ->groupby('t.id')
                 ->orderby('tagcount DESC')
                 ->limit($limit);
                 
        $this->db->execute();         
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
    
    /**
     * Save tags and tag-question relation
     *
     * @param string $strTags
     * @param int $qId
     *
     * @return void
     */
    public function save($strTags = null, $qId = null)
    {
        $tags = $this->prepareTags($strTags);
        $res = $this->saveOnlyNewTags($tags);    // What to do if one res is false?
        $res = $this->updateQuestion2Tag($tags, $qId);
    }
    
    /**
     * Save only new tags
     *
     * @param array $tags
     * 
     * @return void
     */
    public function saveOnlyNewTags($tags = [])
    {
        $res = false;
        $table = $this->db->getTablePrefix() . $this->getSource();
        
        $sql = "INSERT INTO $table (tag)
                SELECT ?
                FROM $table
                WHERE NOT EXISTS(
                    SELECT tag
                    FROM $table
                    WHERE tag = ?
                )
                LIMIT 1;";

        foreach($tags as $tag)
        {
            $res = $this->db->execute($sql, [$tag, $tag]);
        }
        return $res;
    }  

    /**
     * Update question-tag relation
     *
     * @param array $tags
     * @param int $qId
     *
     * @return bool
     */
    public function updateQuestion2Tag($tags = [], $qId = null)
    {
        $table = $this->db->getTablePrefix() . "question2tag";
        $res = $this->deleteWhereQuestionId($qId);
        $params = [];
        
        $sql =  "INSERT INTO $table (idQuestion, idTag) VALUES";
        
        foreach($tags as $tag)
        {
            $sql .= " (?, (SELECT id from " . $this->db->getTablePrefix() . "tag WHERE tag = ?)),";
            $params[] = $qId;
            $params[] = $tag;
        }
        $sql = rtrim($sql, ',');
        
        return $this->db->execute($sql, $params);
    }
    
    /**
     * Delete tags-question relation
     *
     * @param int $qId
     *
     * @return void
     */
    public function deleteWhereQuestionId($qId)
    {
        $this->db->delete(
            'question2tag',
            'idQuestion = ?'
        );
 
        return $this->db->execute([$qId]);
    }
    
    /**
     * Prepare tags before saving to database
     *
     * @param string $strTags
     *
     * @return array $cleanTags
     */
    public function prepareTags($strTags = null)
    {
        $dirtyTags = explode('#', $strTags); 
        foreach($dirtyTags as $tag)
        {
            if(strlen($tag) > 0 && strlen(trim($tag)) > 0)
            {
                $tag = utf8_encode(strtolower(utf8_decode($tag)));
                $cleanTags[] = preg_replace($this->tagPattern, $this->tagReplace, $tag);
            }
        }
        return $cleanTags;
    }
}