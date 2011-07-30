<?php

namespace webgloo\job\mysql {

    use webgloo\common\mysql as MySQL;

    class Application {
        const MODULE_NAME = 'webgloo\common\mysql\Application';

        static function getRecords($organizationId,$openingId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $organizationId = $mysqli->real_escape_string($organizationId);
            $openingId = $mysqli->real_escape_string($openingId);

            $sql = " select * from job_application where org_id = {orgId} and opening_id = {openingId}" ;
            $sql = \str_replace(array("{orgId}", "{openingId}"), array( 0 => $organizationId, 1 => $openingId), $sql);
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }

        static function getRecordsOnUserId($userId) {
            $mysqli = MySQL\Connection::getInstance()->getHandle();
            $userId = $mysqli->real_escape_string($userId);

            $sql = " select opening.organization_name, opening.created_by, opening.bounty, opening.title, app.* " ;
            $sql .= " from job_application app, job_opening opening " ;
            $sql .= " where app.user_id = {userId} and app.opening_id = opening.id" ;
            $sql = str_replace("{userId}", $userId, $sql);
            $rows = MySQL\Helper::fetchRows($mysqli, $sql);
            return $rows;
        }

        static function create($applicationVO) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();

            $sql = " insert into job_application(org_id,user_id,opening_id,forwarder_email,cv_name, cv_title, " ;
            $sql .= " cv_description,cv_email, cv_phone, cv_education,cv_company,cv_location,cv_skill,created_on) ";
            $sql .= " values(?,?,?,?,?,?,?,?,?,?,?,?,?,now()) ";

            $dbCode = MySQL\Connection::ACK_OK;

            $stmt = $mysqli->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("iiissssssssss",
                        $applicationVO->organizationId,
                        $applicationVO->userId,
                        $applicationVO->openingId,
                        $applicationVO->forwarderEmail,
                        $applicationVO->cvName,
                        $applicationVO->cvTitle,
                        $applicationVO->cvDescription,
                        $applicationVO->cvEmail,
                        $applicationVO->cvPhone,
                        $applicationVO->cvEducation,
                        $applicationVO->cvCompnay,
                        $applicationVO->cvLocation,
                        $applicationVO->cvSkill);


                $stmt->execute();

                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }

            return $dbCode;
        }

        static function update($openingId, $openingVO) {

            $mysqli = MySQL\Connection::getInstance()->getHandle();

            $sql = " update job_opening set title = ?, description = ? , bounty = ? , status = ? where id = ? and org_id =? ";
            $dbCode = MySQL\Connection::ACK_OK;

            $stmt = $mysqli->prepare($sql);
            //returns FALSE if prepare flopped
            if ($stmt) {
                $stmt->bind_param("ssssii",
                        $openingVO->title,
                        $openingVO->description,
                        $openingVO->bounty,
                        $openingVO->status,
                        $openingId,
                        $openingVO->organizationId);

                $stmt->execute();
                if ($mysqli->affected_rows != 1) {
                    $dbCode = MySQL\Error::handle(self::MODULE_NAME, $stmt);
                }
                $stmt->close();
            } else {
                $dbCode = MySQL\Error::handle(self::MODULE_NAME, $mysqli);
            }
            return $dbCode;
        }

    }

}
?>
