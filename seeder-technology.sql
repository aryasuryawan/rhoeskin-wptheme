-- Seeder for Technology Page (Post ID: 522)
-- Based on teknologi.html template
-- Run: mysql -u root alya_test < seeder-technology.sql

-- Clear existing data
DELETE FROM wp_postmeta WHERE post_id = 522 AND meta_key = 'alya_tech_categories';

-- Insert technology categories and devices
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
(522, 'alya_tech_categories', 
'CAT::laser | Laser Technology | Sistem Laser Medis Canggih | 01 | LASER TECHNOLOGY | FDA & BPOM Approved | 0
DEV::Nd:YAG 1064nm Laser | Sistem laser Neodymium-doped Yttrium Aluminium Garnet untuk pigmentasi, tato, dan rejuvenasi kulit mendalam. | 0 | Mengatasi melasma & hiperpigmentasi, Laser toning & brightening, Penghilangan tato & bintik hitam, Pengencangan pori-pori | Cutera · USA | FDA Cleared · BPOM RI
DEV::Soprano ICE Platinum | Teknologi diode laser 3-panjang gelombang terpadu untuk laser hair removal yang nyaman dan permanen. | 0 | Triple wavelength: 755nm + 810nm + 1064nm, ICE cooling — nyaman & bebas rasa sakit, Cocok untuk semua jenis kulit, Efektif pada rambut halus sekalipun | Alma Laser · Israel | CE Mark · FDA Cleared
DEV::CO₂ Fractional Laser | Laser karbon dioksida fraksional untuk resurfacing, pengencangan kulit, dan koreksi tekstur wajah menyeluruh. | 0 | Menghilangkan bekas jerawat & scar, Pengencangan kulit non-bedah, Resurfacing pori-pori kasar, Stimulasi kolagen jangka panjang | Lumenis · USA | FDA Cleared · BPOM RI
DEV::PicoWay Picosecond Laser | Laser pikosecond ultra-cepat untuk mengatasi pigmentasi membandel, melasma, dan peremajaan kulit komprehensif. | 0 | Pulsa 300 pikosecond — ultra-presisi, Multi-wavelength (532 / 785 / 1064nm), Minimal downtime, Efektif untuk Fitzpatrick IV–VI | Syneron-Candela · USA | FDA Cleared · CE Mark
CAT::energy | Energy-Based Devices | Perangkat Berbasis Energi | 02 | ENERGY-BASED DEVICES | Non-invasive · No Downtime | 1
DEV::HIFU Ultherapy | High-Intensity Focused Ultrasound satu-satunya yang mendapat FDA clearance untuk face lifting non-bedah. | 0 | Lifting aris, pipi, leher & dagu, Stimulasi kolagen lapisan SMAS, Hasil natural tahan 1–2 tahun, Tanpa sayatan tanpa pemulihan | Ulthera · USA | FDA Approved · BPOM RI
DEV::Thermage FLX | Radiofrequency monopolar generasi terbaru untuk pengencangan dan pemodelan kontur wajah dan tubuh. | 0 | Deep RF hingga lapisan dermis, Total Tip 4.0 — cakupan lebih luas, AccuREP™ adaptive energy delivery, 1 sesi hasil progresif 6 bulan | Thermage · USA | FDA Cleared · CE Mark
CAT::skin | Skin Care Technology | Teknologi Perawatan Kulit | 03 | SKIN CARE TECHNOLOGY | Clinically Tested | 0
DEV::Hydrafacial MD | Teknologi aqua peeling 3-in-1: cleansing, exfoliating, dan infusing serum secara simultan untuk kulit glowing instant. | 0 | Deep cleansing tanpa iritasi, Ekstraksi komedo & blackhead, Infusi antioksidan & peptida, Cocok untuk semua jenis kulit | HydraFacial LLC · USA | FDA Cleared · CE Mark
DEV::Microneedling RF | Kombinasi microneedling dan radiofrequency untuk stimulasi kolagen, pengencangan, dan perbaikan tekstur kulit. | 0 | RF fraksi hingga dermis dalam, Minimal downtime & bleeding, Mengatasi bekas jerawat & pori besar, Pengencangan kulit alami | Lutronic · Korea | FDA Cleared · BPOM RI
CAT::slimming | Slimming Devices | Teknologi Body Sculpting | 04 | SLIMMING DEVICES | Clinically Proven | 0
DEV::CoolSculpting Elite | Teknologi cryolipolysis untuk membekukan dan menghancurkan sel lemak secara permanen tanpa operasi. | 0 | Mengurangi lemak hingga 25% per sesi, Dual applicator — 2x lebih cepat, FDA Cleared untuk 9 area tubuh, Tanpa anestesi tanpa downtime | Allergan · USA | FDA Cleared · BPOM RI
DEV::Emsculpt NEO | Kombinasi RF + HIFEM (High-Intensity Focused Electromagnetic) untuk bakar lemak dan bangun otot secara bersamaan. | 0 | 30% pengurangan lemak + 25% peningkatan otot, Teknologi HIFEM 20.000 kontraksi/sesi, Perut lengan bokong paha, Sesi 30 menit — setara 20.000 sit-up | BTL · Czech Republic | FDA Cleared · CE Mark
CAT::diagnostic | Diagnostic Tools | Peralatan Diagnostik | 05 | DIAGNOSTIC TOOLS | Medical Grade | 1
DEV::VISIA Skin Analysis | Sistem imaging multispektral untuk analisis kondisi kulit secara menyeluruh dan objektif dengan teknologi AI. | 0 | Analisis 8 parameter kulit, UV damage & pore detection, Progress tracking treatment, Database perbandingan demografis | Canfield Scientific · USA | FDA Cleared
DEV::3D Face Scanner | Scanner wajah 3D untuk evaluasi volume, kontur, dan aging pattern dengan presisi submillimeter. | 0 | Pemetaan 3D wajah real-time, Simulasi hasil treatment, Perbandingan before-after akurat, Teknologi depth-sensing camera | Vectra · USA | CE Mark'
);

-- Verify
SELECT post_id, meta_key, LEFT(meta_value, 200) as preview 
FROM wp_postmeta 
WHERE post_id = 522 AND meta_key = 'alya_tech_categories';
