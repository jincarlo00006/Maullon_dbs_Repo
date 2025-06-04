<?php
 
class database {
 
    function opencon() {
        return new PDO(
            'mysql:host=localhost; dbname=dbs_app',
            username: 'root',
            password: ''
        );
    }
 
    function signupUser($firstname, $lastname, $username, $email, $password) {
        $con = $this->opencon();
 
        try {
            $con->beginTransaction();
 
            $stmt = $con->prepare("INSERT INTO Admin (admin_FN, admin_LN, admin_username, admin_email, admin_password) VALUES (?,?,?,?,?)");
 
            $stmt->execute([$firstname, $lastname, $username, $email, $password]);
 
            $userID = $con->lastInsertId();
            $con->commit();
 
            return $userID;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }
    
    //new
    function addStudent($firstname, $lastname, $email, $admin_id) {
        $con = $this->opencon();
 
        try {
            $con->beginTransaction();
 
            $stmt = $con->prepare("INSERT INTO students (student_FN, student_LN,  student_email, admin_id) VALUES (?,?,?,?)");
 
            $stmt->execute([$firstname, $lastname, $email, $admin_id]);
 
            $userID = $con->lastInsertId();
            $con->commit();
 
            return $userID;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }//end

    function addCourse($course_name, $admin_id) {
        $con = $this->opencon();
 
        try {
            $con->beginTransaction();
 
            $stmt = $con->prepare("INSERT INTO courses (course_name, admin_id) VALUES (?,?)");
 
            $stmt->execute([$course_name, $admin_id]);
 
            $userID = $con->lastInsertId();
            $con->commit();
 
            return $userID;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }
 
    function isUsernameExist($username) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_username = ?");
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    function isEmailExist($email) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_email = ?");
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    function isCourseExist($course_name) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM courses WHERE course_name = ?");
        $stmt->execute([$course_name]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    function loginUser($username, $password){
     $con = $this->opencon();
     $stmt = $con->prepare("SELECT * FROM Admin WHERE admin_username = ?");
     $stmt->execute([$username]);
     $user = $stmt->fetch(PDO::FETCH_ASSOC); 
     if($user && password_verify($password, $user['admin_password'])){
        return $user;
     }else{
        return false;
     }
    }

    function getStudents(){
        $con = $this->opencon();
        return $con->query("SELECT * FROM students")->fetchAll();
    }
    
 
}

