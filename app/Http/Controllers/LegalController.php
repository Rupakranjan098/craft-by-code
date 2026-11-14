<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\View\View;

class LegalController extends Controller
{
    /**
     * Effective & Last Updated Dates
     */
    protected string $effectiveDate = 'January 1, 2026';
    protected string $lastUpdatedDate = 'November 14, 2026';
    protected string $officialEmail = 'contact@craftbycode.in';

    /**
     * Privacy Policy Page
     */
    public function privacy(): View
    {
        $brandName = WebsiteSetting::get('brand_name', 'Craft by Code');
        $effectiveDate = $this->effectiveDate;
        $lastUpdatedDate = $this->lastUpdatedDate;
        $officialEmail = $this->officialEmail;

        return view('frontend.legal.privacy', compact('brandName', 'effectiveDate', 'lastUpdatedDate', 'officialEmail'));
    }

    /**
     * Terms & Conditions Page
     */
    public function terms(): View
    {
        $brandName = WebsiteSetting::get('brand_name', 'Craft by Code');
        $effectiveDate = $this->effectiveDate;
        $lastUpdatedDate = $this->lastUpdatedDate;
        $officialEmail = $this->officialEmail;

        return view('frontend.legal.terms', compact('brandName', 'effectiveDate', 'lastUpdatedDate', 'officialEmail'));
    }

    /**
     * Data Security Policy Page
     */
    public function dataSecurity(): View
    {
        $brandName = WebsiteSetting::get('brand_name', 'Craft by Code');
        $effectiveDate = $this->effectiveDate;
        $lastUpdatedDate = $this->lastUpdatedDate;
        $officialEmail = $this->officialEmail;

        return view('frontend.legal.data-security', compact('brandName', 'effectiveDate', 'lastUpdatedDate', 'officialEmail'));
    }

    /**
     * Data Deletion & Data Retention Policy Page
     */
    public function dataRetention(): View
    {
        $brandName = WebsiteSetting::get('brand_name', 'Craft by Code');
        $effectiveDate = $this->effectiveDate;
        $lastUpdatedDate = $this->lastUpdatedDate;
        $officialEmail = $this->officialEmail;

        return view('frontend.legal.data-retention', compact('brandName', 'effectiveDate', 'lastUpdatedDate', 'officialEmail'));
    }

    /**
     * Grievance Officer & Contact Information Page
     */
    public function grievance(): View
    {
        $brandName = WebsiteSetting::get('brand_name', 'Craft by Code');
        $effectiveDate = $this->effectiveDate;
        $lastUpdatedDate = $this->lastUpdatedDate;
        $officialEmail = $this->officialEmail;

        return view('frontend.legal.grievance', compact('brandName', 'effectiveDate', 'lastUpdatedDate', 'officialEmail'));
    }
}
