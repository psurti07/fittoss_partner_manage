<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriveLinks extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'drive_links';

    protected $fillable = ['id', 'rec_date', 'link_type', 'department', 'title', 'link', 'isActive', 'isDelete'];

    public const LINK_TYPES = [
        1 => "In-House",
        2 => "Common",
    ];

    public const DEPARTMENTS = [
        1  => 'A-Sir',
        2  => 'Company Management',
        3  => 'Personal Manager',
        4  => 'HR Recruiter',
        5  => 'Inhouse Human Resource Management',
        6  => 'Data Management',
        7  => 'In Door Reception',
        8  => 'Out Door Reception',
        9  => 'Review Department',
        10 => 'Associate Relationship Manager',
        11 => 'HL Relationship Manager',
        12 => 'Business Development RM',
        13 => 'Associate Royalty Coordinator',
        14 => 'Accounting',
        15 => 'Accounting Coordinator',
        // 16 => 'IT & Professional AMC Coordinator',
        17 => 'Graphic Head',
        18 => 'Associate Partener Graphic Designer',
        19 => 'Associate Content Writer',
        20 => 'Video Editor',
        21 => 'Basic SEO',
        22 => 'IT Coordinator',
        23 => 'Social Media Profile Manager',
        24 => 'Basic Digital Marketing',
        25 => 'Facebook Ad Campaign Coordinator',
        26 => 'Payment Gateway',
        27 => 'Google Ads',
        28 => 'Bulk SMS/RCS',
        29 => 'Trainer Department',
        30 => 'Lead Auto/Webinar',
        31 => 'IVR Department',
        32 => 'Health Coach Auto',
        33 => 'File Accounting',
        34 => 'Online Counselor',
        35 => 'Health Coach Club customer',
        36 => 'Lead Opportunity',
        37 => 'Project Head',
        38 => 'Income Management',
        39 => 'Sign Up Department',
        40 => 'Developer Head',
        41 => 'Website Developer',
        42 => 'Facebook Query',
        43 => 'Profassinal Manager',
        44 => 'Meeting Manager 2',
        45 => 'Meeting Manager 1',
        46 => 'Marketing Coordinator',
        47 => 'CRM WhatsApp Marketing',
        // 48 => 'IT Coordinator',
        49 => 'Marketing Analysis',
        // 50 => 'Graphic Designer',
        51 => 'HL Relationship Manager 2',
        52 => 'Associate Relationship Manager 2',
        // 53 => 'Basic SEO 2',
        // 54 => 'Content Writer 2',
        55 => 'UI Designer',
        56 => 'Chartered accountant (CA)',
        57 => 'Company Security (CS)',
        58 => 'Content Writer',
        59 => 'Health Coach Club Associate',
        60 => 'Meeting Manager 3',
        61 => 'Video Anchor',
        62 => 'Lead Opportunity 2',
    ];
}
