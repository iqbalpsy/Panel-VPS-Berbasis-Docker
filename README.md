# 🚀 XcodeHoster Enterprise Panel VPS

XcodeHoster adalah platform kontrol panel berbasis web yang dirancang untuk manajemen **Virtual Private Server (VPS)** dan **Docker Containers**. Dibangun dengan fokus pada kecepatan, keamanan, dan antarmuka pengguna yang modern menggunakan **Tailwind CSS**.

## ✨ Fitur Utama

* **📊 Smart Control Center**: Monitoring resource server secara real-time (CPU Load, RAM Usage, & Total Containers).
* **📦 VPS Container Management**: Deploy, Start, Stop, Restart, dan Delete container Docker dengan satu klik.
* **💻 Root Virtual Console**: Terminal berbasis web terintegrasi menggunakan **Shellinabox** melalui jalur Reverse Proxy yang aman.
* **🛡️ Security Firewall**: Kelola aturan akses port server (Allow/Deny) secara instan.
* **🎨 Glassmorphism UI**: Antarmuka modern yang bersih, dan responsif (Dark Mode by default).

## 🛠️ Stack Teknologi

* **Backend:** PHP 8.3
* **Frontend:** Tailwind CSS, FontAwesome 6, Google Fonts (Inter)
* **Engine:** Docker Engine API via Shell Execution
* **Terminal:** Shellinabox via Nginx Reverse Proxy
* **Web Server:** Nginx (Ubuntu)

## ⚙️ Persyaratan Sistem

Sebelum menginstal, pastikan server Anda memenuhi spesifikasi berikut:
- Ubuntu 22.04 / 24.04 LTS
- PHP 8.3-FPM atau lebih tinggi
- Docker Engine & Docker Compose
- Shellinabox
- Nginx Web Server

## 🚀 Instalasi Cepat

1. **Clone Repositori**
   ```bash
   git clone [https://github.com/username/vps-panel.git](https://github.com/username/vps-panel.git)
   cd vps-panel
