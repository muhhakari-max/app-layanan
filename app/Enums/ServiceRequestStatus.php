<?php

namespace App\Enums;

enum ServiceRequestStatus: string
{
    case Submitted = 'submitted';
    case DocumentCheck = 'document_check';
    case RevisionRequested = 'revision_requested';
    case DataVerification = 'data_verification';
    case EligibilityVerification = 'eligibility_verification';
    case AwaitingApproval = 'awaiting_approval';
    case Issued = 'issued';
    case RecommendationIssued = 'recommendation_issued';
    case ProposedToMinistry = 'proposed_to_ministry';
    case MinistryApproved = 'ministry_approved';
    case Reactivated = 'reactivated';
    case InProcess = 'in_process';
    case Completed = 'completed';
    case Rejected = 'rejected';
    case MinistryRejected = 'ministry_rejected';

    public function label(): string
    {
        return match ($this) {
            self::Submitted => 'Diajukan',
            self::DocumentCheck => 'Pemeriksaan Berkas',
            self::RevisionRequested => 'Perlu Perbaikan Berkas',
            self::DataVerification => 'Verifikasi Data SIKS-NG',
            self::EligibilityVerification => 'Verifikasi Kelayakan',
            self::AwaitingApproval => 'Menunggu Persetujuan',
            self::Issued => 'Surat Diterbitkan',
            self::RecommendationIssued => 'Rekomendasi Terbit',
            self::ProposedToMinistry => 'Diusulkan ke Kemensos',
            self::MinistryApproved => 'Disetujui Kemensos',
            self::Reactivated => 'Reaktivasi Berhasil',
            self::InProcess => 'Sedang Diproses',
            self::Completed => 'Selesai',
            self::Rejected => 'Ditolak',
            self::MinistryRejected => 'Ditolak Kemensos',
        };
    }
}
