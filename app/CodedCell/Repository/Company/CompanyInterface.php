<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 6/1/2016
 * Time: 12:44
 */

namespace CodedCell\Repository\Company;


interface CompanyInterface
{

    /**
     * get Company Joined with Users Table
     * @return mixed
     */
    public function getCompanyWithUsers();

    /**
     * Get Company Unique Logins
     * @return mixed
     */
    public function getCompanyWithUniqueLogins();
}
