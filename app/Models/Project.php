<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_code', 'lead_id', 'dealer_id', 'customer_name', 'system_type', 'kw_capacity', 'address',
        'base_amount', 'discount_type', 'discount_value', 'discount_amount', 'discount_status', 'discount_approved_by', 'discount_notes',
        'payment_mode', 'current_stage',
        'kyc_completed_at', 'geo_tag_at', 'suryaghar_at', 'payment_selected_at',
        'bank_login_at', 'bank_disbursement_at', 'net_metering_at', 'inspection_at',
        'part_payment_at', 'commissioning_at', 'subsidy_at',
        'total_amount', 'part_payment_amount', 'subsidy_amount', 
        'suryaghar_app_no', 'discom_name', 'consumer_no', 'meter_no',
        'notes', 'status'
    ];

    protected $casts = [
        'kyc_completed_at' => 'datetime',
        'geo_tag_at' => 'datetime',
        'suryaghar_at' => 'datetime',
        'payment_selected_at' => 'datetime',
        'bank_login_at' => 'datetime',
        'bank_disbursement_at' => 'datetime',
        'net_metering_at' => 'datetime',
        'inspection_at' => 'datetime',
        'part_payment_at' => 'datetime',
        'commissioning_at' => 'datetime',
        'subsidy_at' => 'datetime',
    ];

    public function lead() { return $this->belongsTo(Lead::class); }
    public function dealer() { return $this->belongsTo(User::class, 'dealer_id'); }
    public function discountApprover() { return $this->belongsTo(User::class, 'discount_approved_by'); }
    public function quote() { return $this->hasOne(Quote::class); }

    public function isDiscountApproved()
    {
        return $this->discount_status === 'approved' || $this->discount_status === 'none';
    }

    // Get ordered stages based on payment mode
    public static function getStages(string $mode = 'cash'): array
    {
        $common_start = ['kyc_complete','geo_tag_upload','pm_suryaghar_registration','payment_mode_selection'];
        $bank_branch  = ['bank_login','bank_disbursement'];
        $common_end   = ['net_metering','inspection','part_payment','commissioning','subsidy_redemption'];

        if ($mode === 'bank') return array_merge($common_start, $bank_branch, $common_end);
        return array_merge($common_start, $common_end);
    }

    // Human-readable labels
    public static function stageLabel(string $stage): string
    {
        return [
            'kyc_complete'             => 'KYC Complete',
            'geo_tag_upload'           => 'Geo-tag Photo Upload',
            'pm_suryaghar_registration'=> 'PM Suryaghar Registration',
            'payment_mode_selection'   => 'Payment Mode Selection',
            'bank_login'               => 'Bank Login',
            'bank_disbursement'        => 'Bank Disbursement',
            'net_metering'             => 'Net Metering',
            'inspection'               => 'Inspection',
            'part_payment'             => 'Part Payment',
            'commissioning'            => 'Commissioning',
            'subsidy_redemption'       => 'Subsidy Redemption',
        ][$stage] ?? ucfirst($stage);
    }

    // Stage timestamp map
    public function stageTimestamp(string $stage): ?string
    {
        $map = [
            'kyc_complete'             => $this->kyc_completed_at,
            'geo_tag_upload'           => $this->geo_tag_at,
            'pm_suryaghar_registration'=> $this->suryaghar_at,
            'payment_mode_selection'   => $this->payment_selected_at,
            'bank_login'               => $this->bank_login_at,
            'bank_disbursement'        => $this->bank_disbursement_at,
            'net_metering'             => $this->net_metering_at,
            'inspection'               => $this->inspection_at,
            'part_payment'             => $this->part_payment_at,
            'commissioning'            => $this->commissioning_at,
            'subsidy_redemption'       => $this->subsidy_at,
        ];
        return $map[$stage] ? $map[$stage]->format('d M Y') : null;
    }

    // Is a stage completed?
    public function isStageCompleted(string $stage): bool
    {
        $stages = self::getStages($this->payment_mode);
        $currentIdx = array_search($this->current_stage, $stages);
        $stageIdx   = array_search($stage, $stages);
        return $stageIdx !== false && $stageIdx < $currentIdx;
    }

    // Progress percentage
    public function progressPercent(): int
    {
        $stages = self::getStages($this->payment_mode);
        $currentIdx = array_search($this->current_stage, $stages);
        if ($currentIdx === false) return 0;
        return (int)(($currentIdx / (count($stages) - 1)) * 100);
    }
}
