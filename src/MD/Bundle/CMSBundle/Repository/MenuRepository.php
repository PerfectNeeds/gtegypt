<?php

namespace MD\Bundle\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository {

    /**
     *
     * @return array of object
     */
    public function getParents() {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT m.id "
                . "FROM menu m "
                . "LEFT OUTER "
                . "JOIN menu_has_parent mhp ON m.id=mhp.child_id "
                . "WHERE mhp.child_id IS NULL AND m.deleted=:deleted";
        $statement = $connection->prepare($sql);
        $statement->bindValue("deleted", FALSE);
        $statement->execute();
        $queryResult = $statement->fetchAll();
        if (!$queryResult) {
            return FALSE;
        }

        $result = array();
        foreach ($queryResult as $key => $r) {
            $result[] = $this->getEntityManager()->getRepository('CMSBundle:Menu')->find($r['id']);
        }

        if ($result == null) {
            return;
        } else {
            return $result;
        }
    }

    public function getParentsByTabId($tabId) {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT m.id "
                . "FROM menu m "
                . "LEFT OUTER "
                . "JOIN menu_has_parent mhp ON m.id=mhp.child_id "
                . "WHERE mhp.child_id IS NULL AND m.deleted=:deleted AND m.tab_id=:tabId";
        $statement = $connection->prepare($sql);
        $statement->bindValue("deleted", FALSE);
        $statement->bindValue("tabId", $tabId);
        $statement->execute();
        $queryResult = $statement->fetchAll();
        if (!$queryResult) {
            return FALSE;
        }

        $result = array();
        foreach ($queryResult as $key => $r) {
            $result[] = $this->getEntityManager()->getRepository('CMSBundle:Menu')->find($r['id']);
        }

        if ($result == null) {
            return;
        } else {
            return $result;
        }
    }

    /**
     *
     * @return array of object
     */
    public function getChilds($parentId) {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT m.id "
                . "FROM menu m "
                . "LEFT OUTER "
                . "JOIN menu_has_parent mhp ON m.id=mhp.child_id "
                . "WHERE mhp.parent_id = :parentId AND m.deleted=:deleted";
        $statement = $connection->prepare($sql);
        $statement->bindValue("deleted", FALSE);
        $statement->bindValue("parentId", $parentId);
        $statement->execute();
        $queryResult = $statement->fetchAll();
        if (!$queryResult) {
            return FALSE;
        }

        $result = array();
        foreach ($queryResult as $key => $r) {
            $result[] = $this->getEntityManager()->getRepository('CMSBundle:Menu')->find($r['id']);
        }

        if ($result == null) {
            return;
        } else {
            return $result;
        }
    }

    public function getParent($childsId) {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT m.id "
                . "FROM menu m "
                . "LEFT OUTER "
                . "JOIN menu_has_parent mhp ON m.id=mhp.parent_id "
                . "WHERE mhp.child_id = :childsId AND m.deleted=:deleted";

        $statement = $connection->prepare($sql);
        $statement->bindValue("deleted", FALSE);
        $statement->bindValue("childsId", $childsId);
        $statement->execute();
        $queryResult = $statement->fetch();
        if (!$queryResult) {
            return FALSE;
        }

        $result = $this->getEntityManager()->getRepository('CMSBundle:Menu')->find($queryResult['id']);

        if ($result == null) {
            return;
        } else {
            return $result;
        }
    }

}
