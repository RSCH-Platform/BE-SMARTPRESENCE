<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SmartPresenceSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */

        DB::table('roles')->insert([
            ['id'=>1,'role'=>'super_admin'],
            ['id'=>2,'role'=>'admin'],
            ['id'=>3,'role'=>'sekretatris']
        ]);


        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        DB::table('users')->insert([
            [
                'username'=>'SuperAdmin',
                'email'=>'superadmin@mail.com',
                'password'=>'password',
                'role_id'=>1,
                'is_active'=>true,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'username'=>'Admin',
                'email'=>'admin@mail.com',
                'password'=>'password',
                'role_id'=>2,
                'is_active'=>true,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'username'=>'Sekretaris',
                'email'=>'sekretaris@mail.com',
                'password'=>'password',
                'role_id'=>3,
                'is_active'=>true,
                'created_at'=>now(),
                'updated_at'=>now()
            ],

    // SPI
    [
        'username'=>'admin_spi',
        'email'=>'',
        'password'=>'BintangSPI27',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_spi',
        'email'=>'',
        'password'=>'PelangiSPI82',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Direksi
    [
        'username'=>'admin_direksi',
        'email'=>'',
        'password'=>'MentariDireksi14',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_direksi',
        'email'=>'',
        'password'=>'SamudraDireksi69',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Pemasaran
    [
        'username'=>'admin_pemasaran',
        'email'=>'',
        'password'=>'RajawaliPemasaran31',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_pemasaran',
        'email'=>'',
        'password'=>'MawarPemasaran88',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // IGD
    [
        'username'=>'admin_igd',
        'email'=>'',
        'password'=>'KompasIGD25',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_igd',
        'email'=>'',
        'password'=>'LenteraIGD73',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Pelayanan Medis
    [
        'username'=>'admin_pelayananmedis',
        'email'=>'',
        'password'=>'AnggrekMedis42',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_pelayananmedis',
        'email'=>'',
        'password'=>'CakrawalaMedis91',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Casemix
    [
        'username'=>'admin_casemix',
        'email'=>'',
        'password'=>'DelimaCasemix36',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_casemix',
        'email'=>'',
        'password'=>'KenangaCasemix57',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Rawat Jalan
    [
        'username'=>'admin_rawatjalan',
        'email'=>'',
        'password'=>'MerpatiRawat18',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_rawatjalan',
        'email'=>'',
        'password'=>'NusantaraRawat84',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // K3
    [
        'username'=>'admin_k3',
        'email'=>'',
        'password'=>'GarudaK358',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_k3',
        'email'=>'',
        'password'=>'SenjaK312',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Penunjang Medis
    [
        'username'=>'admin_penunjangmedis',
        'email'=>'',
        'password'=>'BerlianPenunjang44',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_penunjangmedis',
        'email'=>'',
        'password'=>'EmbunPenunjang76',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Keperawatan
    [
        'username'=>'admin_keperawatan',
        'email'=>'',
        'password'=>'HarapanPerawat23',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_keperawatan',
        'email'=>'',
        'password'=>'BahariPerawat67',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // PKRS
    [
        'username'=>'admin_pkrs',
        'email'=>'',
        'password'=>'MahkotaPKRS39',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_pkrs',
        'email'=>'',
        'password'=>'MelatiPKRS83',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // PPI
    [
        'username'=>'admin_ppi',
        'email'=>'',
        'password'=>'PelitaPPI41',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_ppi',
        'email'=>'',
        'password'=>'KencanaPPI79',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // HD
    [
        'username'=>'admin_hd',
        'email'=>'',
        'password'=>'SakuraHD11',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_hd',
        'email'=>'',
        'password'=>'LaksanaHD63',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Teratai
    [
        'username'=>'admin_teratai',
        'email'=>'',
        'password'=>'TerataiEmas24',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_teratai',
        'email'=>'',
        'password'=>'TerataiBiru85',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Anturium
    [
        'username'=>'admin_anturium',
        'email'=>'',
        'password'=>'AnturiumHijau47',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_anturium',
        'email'=>'',
        'password'=>'AnturiumUngu92',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Rosalina
    [
        'username'=>'admin_rosalina',
        'email'=>'',
        'password'=>'RosalinaMerah53',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_rosalina',
        'email'=>'',
        'password'=>'RosalinaPutih16',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // ICU
    [
        'username'=>'admin_icu',
        'email'=>'',
        'password'=>'JagatICU72',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_icu',
        'email'=>'',
        'password'=>'LangitICU29',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Alamanda
    [
        'username'=>'admin_alamanda',
        'email'=>'',
        'password'=>'AlamandaKuning61',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_alamanda',
        'email'=>'',
        'password'=>'AlamandaJingga34',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Perinatologi
    [
        'username'=>'admin_perinatologi',
        'email'=>'',
        'password'=>'KasihPerina48',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_perinatologi',
        'email'=>'',
        'password'=>'BundaPerina95',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // OK
    [
        'username'=>'admin_ok',
        'email'=>'',
        'password'=>'PusakaOK13',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_ok',
        'email'=>'',
        'password'=>'MustikaOK81',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Mutu
    [
        'username'=>'admin_mutu',
        'email'=>'',
        'password'=>'MutiaraMutu26',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_mutu',
        'email'=>'',
        'password'=>'PratamaMutu74',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Lotus
    [
        'username'=>'admin_lotus',
        'email'=>'',
        'password'=>'LotusPerak38',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_lotus',
        'email'=>'',
        'password'=>'LotusKristal65',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Tulip
    [
        'username'=>'admin_tulip',
        'email'=>'',
        'password'=>'TulipCerah43',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_tulip',
        'email'=>'',
        'password'=>'TulipDamai87',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Farmasi
    [
        'username'=>'admin_farmasi',
        'email'=>'',
        'password'=>'FarmasiSehat21',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_farmasi',
        'email'=>'',
        'password'=>'FarmasiPrima68',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // VK
    [
        'username'=>'admin_vk',
        'email'=>'',
        'password'=>'BahagiaVK54',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_vk',
        'email'=>'',
        'password'=>'SentosaVK19',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Laboratorium
    [
        'username'=>'admin_laboratorium',
        'email'=>'',
        'password'=>'LabCemerlang46',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_laboratorium',
        'email'=>'',
        'password'=>'LabGemilang77',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Rekam Medis
    [
        'username'=>'admin_rekammedis',
        'email'=>'',
        'password'=>'ArsipMedis28',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_rekammedis',
        'email'=>'',
        'password'=>'DataMedis86',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Radiologi
    [
        'username'=>'admin_radiologi',
        'email'=>'',
        'password'=>'SinarRadiologi35',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_radiologi',
        'email'=>'',
        'password'=>'GammaRadiologi71',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Gizi
    [
        'username'=>'admin_gizi',
        'email'=>'',
        'password'=>'NutrisiGizi22',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_gizi',
        'email'=>'',
        'password'=>'VitaminGizi64',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Umum RT
    [
        'username'=>'admin_umumrt',
        'email'=>'',
        'password'=>'MandiriRT17',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_umumrt',
        'email'=>'',
        'password'=>'SejahteraRT93',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Kepegawaian
    [
        'username'=>'admin_umumkepegawaian',
        'email'=>'',
        'password'=>'PegawaiHebat51',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_umumkepegawaian',
        'email'=>'',
        'password'=>'PegawaiUnggul78',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // TPP
    [
        'username'=>'admin_tpp',
        'email'=>'',
        'password'=>'HarmoniTPP32',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_tpp',
        'email'=>'',
        'password'=>'PrestasiTPP89',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // IPP
    [
        'username'=>'admin_ipp',
        'email'=>'',
        'password'=>'PelangganSetia27',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_ipp',
        'email'=>'',
        'password'=>'LayananPrima84',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Keuangan
    [
        'username'=>'admin_keuangan',
        'email'=>'',
        'password'=>'SaldoKeuangan56',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_keuangan',
        'email'=>'',
        'password'=>'NeracaKeuangan15',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Akuntansi
    [
        'username'=>'admin_akuntansi',
        'email'=>'',
        'password'=>'JurnalAkuntansi62',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_akuntansi',
        'email'=>'',
        'password'=>'LedgerAkuntansi37',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Perpajakan
    [
        'username'=>'admin_perpajakan',
        'email'=>'',
        'password'=>'PajakTertib49',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_perpajakan',
        'email'=>'',
        'password'=>'PajakAman94',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Sekretariat
    [
        'username'=>'admin_sekretariat',
        'email'=>'',
        'password'=>'SekretariatMaju33',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_sekretariat',
        'email'=>'',
        'password'=>'SekretariatHebat82',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Kasir
    [
        'username'=>'admin_kasir',
        'email'=>'',
        'password'=>'KasirCerdas52',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_kasir',
        'email'=>'',
        'password'=>'KasirCepat18',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Transportasi
    [
        'username'=>'admin_transportasi',
        'email'=>'',
        'password'=>'TransportLancar45',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_transportasi',
        'email'=>'',
        'password'=>'TransportAman97',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Kebersihan
    [
        'username'=>'admin_kebersihan',
        'email'=>'',
        'password'=>'BersihKinclong24',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_kebersihan',
        'email'=>'',
        'password'=>'RapiWangi73',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // CSSD
    [
        'username'=>'admin_cssd',
        'email'=>'',
        'password'=>'SterilCSSD58',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_cssd',
        'email'=>'',
        'password'=>'HigienisCSSD14',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Akupunktur
    [
        'username'=>'admin_akunpuktur',
        'email'=>'',
        'password'=>'JarumSehat66',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_akunpuktur',
        'email'=>'',
        'password'=>'TerapiNyaman31',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Diklat
    [
        'username'=>'admin_kepegawaiandiklat',
        'email'=>'',
        'password'=>'DiklatUnggul42',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_kepegawaiandiklat',
        'email'=>'',
        'password'=>'BelajarMaju88',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // TIK
    [
        'username'=>'admin_tik',
        'email'=>'',
        'password'=>'DigitalTIK57',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_tik',
        'email'=>'',
        'password'=>'TeknologiTIK23',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // TI
    [
        'username'=>'admin_ti',
        'email'=>'',
        'password'=>'ServerTI69',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_ti',
        'email'=>'',
        'password'=>'JaringanTI12',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Laundry
    [
        'username'=>'admin_laundry',
        'email'=>'',
        'password'=>'LaundryBersih47',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_laundry',
        'email'=>'',
        'password'=>'LaundryHarum91',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    // Keamanan
    [
        'username'=>'admin_keamanan',
        'email'=>'',
        'password'=>'KeamananSiaga36',
        'role_id'=>2,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'username'=>'sekre_keamanan',
        'email'=>'',
        'password'=>'PenjagaAman75',
        'role_id'=>3,
        'is_active'=>true,
        'created_at'=>now(),
        'updated_at'=>now()
    ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | EMPLOYEE TYPES
        |--------------------------------------------------------------------------
        */
        DB::table('employee_types')->insert([
            ['id'=>1,'employee_type'=>'Dokter Umum'],
            ['id'=>2,'employee_type'=>'Dokter Gigi'],
            ['id'=>3,'employee_type'=>'Dokter Spesialis'],
            ['id'=>4,'employee_type'=>'Dokter Gigi Spesialis'],
            ['id'=>5,'employee_type'=>'Perawat'],
            ['id'=>6,'employee_type'=>'Bidan'],
            ['id'=>7,'employee_type'=>'Apoteker'],
            ['id'=>8,'employee_type'=>'Tenaga Teknis Kefarmasian'],
            ['id'=>9,'employee_type'=>'Analis Kesehatan'],
            ['id'=>10,'employee_type'=>'Perekam Medis'],
            ['id'=>11,'employee_type'=>'Radiografer'],
            ['id'=>12,'employee_type'=>'Ahli Gizi'],
            ['id'=>13,'employee_type'=>'Sanitarian'],
            ['id'=>14,'employee_type'=>'ATEM'],
            ['id'=>15,'employee_type'=>'Refraksionis Optisien'],
            ['id'=>16,'employee_type'=>'Fisioterapis'],
            ['id'=>17,'employee_type'=>'Psikolog'],
            ['id'=>18,'employee_type'=>'Direksi'],
            ['id'=>19,'employee_type'=>'Non-Kesehatan'],
            ['id'=>20,'employee_type'=>'TTK'],
            ['id'=>21,'employee_type'=>'Konsultan'],
            ['id'=>22,'employee_type'=>'Tamu'],
           

        ]);

        /*
        |--------------------------------------------------------------------------
        | WORK UNITS
        |--------------------------------------------------------------------------
        */
        DB::table('work_units')->insert([
            ['id'=>1,'work_unit'=>'SPI'],
            ['id'=>2,'work_unit'=>'Direksi'],
            ['id'=>3,'work_unit'=>'Pemasaran'],
            ['id'=>4,'work_unit'=>'IGD'],
            ['id'=>5,'work_unit'=>'Pelayanan Medis'],
            ['id'=>6,'work_unit'=>'Casemix'],
            ['id'=>7,'work_unit'=>'Rawat Jalan'],
            ['id'=>8,'work_unit'=>'K3'],
            ['id'=>9,'work_unit'=>'Penunjang Medis'],
            ['id'=>10,'work_unit'=>'Keperawatan'],
            ['id'=>11,'work_unit'=>'PKRS'],
            ['id'=>12,'work_unit'=>'PPI'],
            ['id'=>13,'work_unit'=>'HD'],
            ['id'=>14,'work_unit'=>'Teratai'],
            ['id'=>15,'work_unit'=>'Anturium'],
            ['id'=>16,'work_unit'=>'Rosalina'],
            ['id'=>17,'work_unit'=>'ICU'],
            ['id'=>18,'work_unit'=>'Alamanda'],
            ['id'=>19,'work_unit'=>'Perinatologi'],
            ['id'=>20,'work_unit'=>'OK'],
            ['id'=>21,'work_unit'=>'Mutu'],
            ['id'=>22,'work_unit'=>'Lotus'],
            ['id'=>23,'work_unit'=>'Tulip'],
            ['id'=>24,'work_unit'=>'Farmasi'],
            ['id'=>25,'work_unit'=>'VK'],
            ['id'=>26,'work_unit'=>'Laboratorium'],
            ['id'=>27,'work_unit'=>'Rekam Medis'],
            ['id'=>28,'work_unit'=>'Radiologi'],
            ['id'=>29,'work_unit'=>'Gizi'],
            ['id'=>30,'work_unit'=>'Umum RT'],
            ['id'=>31,'work_unit'=>'Umum Kepegawaian'],
            ['id'=>32,'work_unit'=>'TPP'],
            ['id'=>33,'work_unit'=>'Informasi & Pengelolaan Pelanggan'],
            ['id'=>34,'work_unit'=>'Keuangan'],
            ['id'=>35,'work_unit'=>'Akuntansi'],
            ['id'=>36,'work_unit'=>'Perpajakan'],
            ['id'=>37,'work_unit'=>'Sekretariat'],
            ['id'=>38,'work_unit'=>'Kasir'],
            ['id'=>39,'work_unit'=>'Transportasi'],
            ['id'=>40,'work_unit'=>'Kebersihan'],
            ['id'=>41,'work_unit'=>'CSSD'],
            ['id'=>42,'work_unit'=>'Akunpuktur'],
            ['id'=>43,'work_unit'=>'Kepegawaian Diklat'],
            ['id'=>44,'work_unit'=>'Informasi & TIK'],
            ['id'=>45,'work_unit'=>'TI'],
            ['id'=>46,'work_unit'=>'Laundry'],
            ['id'=>47,'work_unit'=>'Keamanan'],
        ]);




        /*
        |--------------------------------------------------------------------------
        | EMPLOYEES
        |--------------------------------------------------------------------------
        */

        DB::table('employees')->insert([
            [
                'full_name'=>'dr. H. M. Arief Heriawan, Sp.B',
                'nip'=>'0411.02218',
                'employee_type_id'=> 3,
                'work_unit_id'=> null,
                'email'=>null,
                'phone'=>null,
                'is_active'=>true,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'full_name'=>'dr. Yuli Hermansyah, Sp.PD',
                'nip'=>'0411.02219',
                'employee_type_id'=> 3,
                'work_unit_id'=> null,
                'email'=>null,
                'phone'=>null,
                'is_active'=>true,
                'created_at'=>now(),
                'updated_at'=>now()
            ]
        ]);
        /*
        |--------------------------------------------------------------------------
        | MEETING ROOMS
        |--------------------------------------------------------------------------
        */

        DB::table('meeting_rooms')->insert([
            [
                'name'=>'Ruang Rapat Utama',
                'location'=>'Lantai 1',
                'capacity'=>20,
                'is_active'=>true,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'Ruang Meeting 2',
                'location'=>'Lantai 2',
                'capacity'=>15,
                'is_active'=>true,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | MEETINGS
        |--------------------------------------------------------------------------
        */

        DB::table('meetings')->insert([
            [
                'title'=>'Rapat Evaluasi Bulanan',
                'room_id'=>1,
                'start_time'=>Carbon::now()->addDay(),
                'end_time'=>Carbon::now()->addDay()->addHour(),
                'status'=>'menunggu',
                'created_by'=>2,
                'created_at'=>now(),
                'updated_at'=>now()
            ]
        ]);


        /*
        |--------------------------------------------------------------------------
        | MEETING PARTICIPANTS
        |--------------------------------------------------------------------------
        */

        DB::table('meeting_participants')->insert([
            [
                'meeting_id'=>1,
                'employee_id'=>1,
                'created_at'=>now()
            ],
            [
                'meeting_id'=>1,
                'employee_id'=>2,
                'created_at'=>now()
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | ATTENDANCES
        |--------------------------------------------------------------------------
        */

        DB::table('attendances')->insert([
            [
                'meeting_id'=>1,
                'employee_id'=>1,
                'check_in_time'=>Carbon::now(),
                'status'=>'hadir',
                'verified_by'=>2,
                'notes'=>null,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'meeting_id'=>1,
                'employee_id'=>2,
                'check_in_time'=>Carbon::now(),
                'status'=>'hadir',
                'verified_by'=>2,
                'notes'=>null,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | MEETING ASSIGNMENTS
        |--------------------------------------------------------------------------
        */

        DB::table('meeting_assignments')->insert([
            [
                'meeting_id'=>1,
                'user_id'=>2,
                'assigned_by'=>1,
                'created_at'=>now()
            ]
        ]);

    }
}