<?php

namespace Tests\Feature;

use App\Enums\ComplaintStatus;
use App\Enums\DocumentVerificationStatus;
use App\Enums\HandlingType;
use App\Enums\ReferralStatus;
use App\Enums\RehabilitationCaseStatus;
use App\Enums\ServiceHandler;
use App\Enums\ServiceRequestStatus;
use App\Models\Assessment;
use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use App\Models\ComplaintCategory;
use App\Models\District;
use App\Models\DtsenCertificate;
use App\Models\DtsenPurpose;
use App\Models\MonitoringRecord;
use App\Models\NumberSequence;
use App\Models\Referral;
use App\Models\ReferralInstitution;
use App\Models\RehabilitationCase;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceRequirement;
use App\Models\ServiceType;
use App\Models\User;
use App\Models\Village;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SapaSosialModelsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_generate_ticket_number_sequences(): void
    {
        DB::transaction(function () {
            $ticket1 = NumberSequence::generateNextNumber('DTSEN', '202610');
            $ticket2 = NumberSequence::generateNextNumber('DTSEN', '202610');
            $ticketPbi = NumberSequence::generateNextNumber('PBI', '202610');

            $this->assertEquals('DTSEN-202610-00001', $ticket1);
            $this->assertEquals('DTSEN-202610-00002', $ticket2);
            $this->assertEquals('PBI-202610-00001', $ticketPbi);
        });
    }

    public function test_can_create_master_data_and_users(): void
    {
        $district = District::create([
            'code' => '3505010',
            'name' => 'Wlingi',
        ]);

        $village = Village::create([
            'district_id' => $district->id,
            'code' => '3505010001',
            'name' => 'Babadan',
        ]);

        $user = User::create([
            'name' => 'Petugas Pelayanan',
            'email' => 'petugas@blitar.go.id',
            'password' => bcrypt('password'),
            'phone' => '081234567890',
            'nik' => '3505010101010001',
            'district_id' => $district->id,
            'village_id' => $village->id,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('users', ['email' => 'petugas@blitar.go.id']);
        $this->assertEquals($district->id, $user->district->id);
        $this->assertEquals($village->id, $user->village->id);
    }

    public function test_can_create_service_request_with_dtsen_certificate(): void
    {
        $district = District::create(['code' => '3505020', 'name' => 'Kanigoro']);
        $village = Village::create(['district_id' => $district->id, 'code' => '3505020001', 'name' => 'Kanigoro']);

        $serviceType = ServiceType::create([
            'code' => 'DTSEN',
            'name' => 'Surat Keterangan DTSEN',
            'category' => 'Pelayanan Sosial',
            'handler' => ServiceHandler::Dtsen,
            'needs_assessment' => false,
            'is_active' => true,
        ]);

        $requirement = ServiceRequirement::create([
            'service_type_id' => $serviceType->id,
            'name' => 'KTP & KK',
            'is_mandatory' => true,
            'allowed_mimes' => 'pdf,jpg,png',
        ]);

        $purpose = DtsenPurpose::create([
            'code' => 'spmb',
            'name' => 'SPMB Jalur Afirmasi',
            'max_decile' => 5,
            'validity_days' => 30,
            'is_active' => true,
        ]);

        $request = ServiceRequest::create([
            'request_number' => 'DTSEN-202610-00001',
            'service_type_id' => $serviceType->id,
            'applicant_name' => 'Budi Santoso',
            'applicant_nik' => '3505020101900001',
            'family_card_number' => '3505020101900002',
            'address' => 'Jl. Merdeka No. 10',
            'village_id' => $village->id,
            'phone' => '081299887766',
            'status' => ServiceRequestStatus::Submitted,
            'submitted_at' => now(),
        ]);

        $document = ServiceRequestDocument::create([
            'service_request_id' => $request->id,
            'service_requirement_id' => $requirement->id,
            'file_path' => 'documents/ktp_budi.pdf',
            'original_name' => 'ktp_budi.pdf',
            'verification_status' => DocumentVerificationStatus::Valid,
        ]);

        $certificate = DtsenCertificate::create([
            'service_request_id' => $request->id,
            'dtsen_purpose_id' => $purpose->id,
            'purpose_description' => 'Untuk pendaftaran SPMB',
            'subject_name' => 'Anak Budi',
            'subject_nik' => '3505020101150001',
            'relationship_to_applicant' => 'Anak Kandung',
            'is_registered' => true,
            'decile' => 2,
            'checked_at' => now(),
            'verification_code' => 'QR-DTSEN-12345',
        ]);

        $this->assertEquals($serviceType->id, $request->serviceType->id);
        $this->assertEquals($certificate->id, $request->dtsenCertificate->id);
        $this->assertEquals($request->id, $document->serviceRequest->id);
        $this->assertEquals(ServiceRequestStatus::Submitted, $request->status);
    }

    public function test_can_create_rehabilitation_case_flow(): void
    {
        $category = ClientCategory::create(['name' => 'Lansia Terlantar', 'is_active' => true]);

        $district = District::create(['code' => '3505030', 'name' => 'Sutojayan']);
        $village = Village::create(['district_id' => $district->id, 'code' => '3505030001', 'name' => 'Kembangarum']);

        $officer = User::create([
            'name' => 'Petugas Rehsos',
            'email' => 'rehsos@blitar.go.id',
            'password' => bcrypt('password'),
        ]);

        $client = Client::create([
            'name' => 'Mbah Sutrisno',
            'client_category_id' => $category->id,
            'gender' => 'L',
            'address' => 'Dusun Krajan',
            'village_id' => $village->id,
        ]);

        $case = RehabilitationCase::create([
            'case_number' => 'RHS-202610-00001',
            'client_id' => $client->id,
            'officer_id' => $officer->id,
            'handling_type' => HandlingType::Referral,
            'status' => RehabilitationCaseStatus::Received,
            'received_at' => now(),
        ]);

        $assessment = Assessment::create([
            'rehabilitation_case_id' => $case->id,
            'officer_id' => $officer->id,
            'assessment_date' => now(),
            'result' => 'Kondisi lansia sebatang kara, butuh perawatan panti',
            'service_needs' => 'Perawatan di panti lansia',
            'recommendation' => 'Rujuk ke Balai Pelayanan Sosial Tresna Werdha',
            'needs_referral' => true,
        ]);

        $institution = ReferralInstitution::create([
            'name' => 'Panti Werdha Blitar',
            'type' => 'panti',
            'address' => 'Blitar',
            'is_active' => true,
        ]);

        $referral = Referral::create([
            'referral_number' => 'RJK-202610-00001',
            'rehabilitation_case_id' => $case->id,
            'assessment_id' => $assessment->id,
            'referral_institution_id' => $institution->id,
            'officer_id' => $officer->id,
            'referral_date' => now(),
            'status' => ReferralStatus::Draft,
        ]);

        $monitoring = MonitoringRecord::create([
            'rehabilitation_case_id' => $case->id,
            'referral_id' => $referral->id,
            'officer_id' => $officer->id,
            'monitoring_date' => now(),
            'progress' => 'Klien dalam kondisi sehat di panti',
        ]);

        $this->assertEquals($client->id, $case->client->id);
        $this->assertEquals(1, $case->assessments()->count());
        $this->assertEquals(1, $case->referrals()->count());
        $this->assertEquals(1, $case->monitoringRecords()->count());
    }

    public function test_can_create_complaint_and_attachments(): void
    {
        $district = District::create(['code' => '3505040', 'name' => 'Garum']);
        $village = Village::create(['district_id' => $district->id, 'code' => '3505040001', 'name' => 'Garum']);

        $category = ComplaintCategory::create(['name' => 'Lansia Terlantar', 'is_active' => true]);

        $complaint = Complaint::create([
            'complaint_number' => 'ADU-202610-00001',
            'complaint_category_id' => $category->id,
            'reporter_name' => 'Warga Peduli',
            'reporter_phone' => '085511223344',
            'location_detail' => 'Dekat Pasar Garum',
            'village_id' => $village->id,
            'description' => 'Ada lansia terlantar membutuhkan pertolongan',
            'reported_at' => now(),
            'status' => ComplaintStatus::Received,
        ]);

        $attachment = ComplaintAttachment::create([
            'complaint_id' => $complaint->id,
            'file_path' => 'complaints/foto1.jpg',
            'type' => 'photo',
        ]);

        $this->assertEquals(1, $complaint->attachments()->count());
        $this->assertEquals(ComplaintStatus::Received, $complaint->status);
    }
}
