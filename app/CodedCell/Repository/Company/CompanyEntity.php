<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 6/1/2016
 * Time: 12:48
 */

namespace CodedCell\Repository\Company;


use Illuminate\Support\Facades\DB;

class CompanyEntity implements CompanyInterface
{
    public function getCompanyWithUsers()
    {
        // TODO: Implement getCompanyWithUsers() method.
    }

    public function getCompanyWithUniqueLogins()
    {
        return DB::table('users')
            ->leftJoin('companies', 'users.companyId', '=', 'companies.id')
            ->select(DB::raw('min(users.id) as userid'), 'users.companyId', 'companies.id', 'companies.companyCliReports')
            ->groupBy('users.companyId')
            ->get();
    }
}
