<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Analisis Data | Satu Data OPD</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #eaf1ff;

            --ink: #0f1f3d;
            --accent: #0ea5a4;
            --accent-soft: #e0f7f6;

            --bg: #f5f7fb;
            --white: #ffffff;

            --text: #1b2a44;
            --muted: #6b7a93;
            --border: #e6ebf3;

            --green: #10a36a;
            --green-soft: #e3f8ee;
            --orange: #e08a0b;
            --orange-soft: #fff3dc;
            --purple: #6d5bd0;
            --purple-soft: #eeebfd;

            --shadow-sm: 0 1px 2px rgba(15, 31, 61, .04);
            --shadow: 0 4px 20px rgba(15, 31, 61, .06);
            --shadow-lg: 0 12px 32px rgba(37, 99, 235, .12);
            --radius: 18px;

            --sidebar-width: 264px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, Arial, sans-serif;
            background:
                radial-gradient(900px 400px at 100% -5%, rgba(37,99,235,.07), transparent 60%),
                radial-gradient(700px 360px at 0% 0%, rgba(14,165,164,.06), transparent 60%),
                var(--bg);
            background-attachment: fixed;
            color: var(--text);
            font-size: 13.5px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        input,
        select {
            font: inherit;
        }

        :focus-visible {
            outline: 3px solid rgba(37,99,235,.4);
            outline-offset: 2px;
        }

        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            background: var(--white);
            border-right: 1px solid var(--border);

            display: flex;
            flex-direction: column;

            padding: 22px 16px 18px;

            z-index: 20;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 4px 8px 22px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;

            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;

            display: grid;
            place-items: center;

            border-radius: 14px;
            flex-shrink: 0;

            box-shadow: 0 8px 18px rgba(37,99,235,.28);
        }

        .brand-icon svg {
            width: 22px;
            height: 22px;
        }

        .brand-title {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -.2px;
            color: var(--ink);
        }

        .brand-subtitle {
            font-size: 11px;
            color: var(--muted);
            margin-top: 1px;
        }

        .nav-label {
            color: #9aa7bd;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 1.2px;

            padding: 10px 12px 10px;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;

            min-height: 46px;
            padding: 9px 14px;

            border-radius: 12px;

            color: #52627e;
            font-weight: 600;

            transition: background .18s ease, color .18s ease;
        }

        .nav-link svg {
            width: 28px;
            height: 28px;
            padding: 6px;
            flex-shrink: 0;

            border-radius: 8px;
            background: #f2f5fb;

            transition: background .18s ease, color .18s ease;
        }

        .nav-link:hover {
            background: #f2f5fb;
            color: var(--ink);
        }

        .nav-link.active {
            background: var(--primary-light);
            color: var(--primary);

            font-weight: 700;
        }

        .nav-link.active svg {
            background: var(--primary);
            color: #fff;
        }

        .nav-tag {
            margin-left: auto;

            font-size: 9.5px;
            font-weight: 700;

            color: #667085;
            background: #f2f5fb;

            padding: 3px 9px;

            border-radius: 999px;
        }

        .nav-link.active .nav-tag {
            color: var(--primary);
            background: #fff;
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .version-card {
            background: linear-gradient(135deg, #f1f6ff, #eefaf9);
            border: 1px solid var(--border);

            border-radius: 14px;

            padding: 14px 16px;
        }

        .version-title {
            font-size: 12px;
            font-weight: 700;
            color: var(--ink);

            margin-bottom: 5px;
        }

        .version-desc {
            font-size: 11px;
            line-height: 1.6;

            color: var(--muted);
        }

        .version-dot {
            display: inline-block;

            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: #12b76a;

            margin-right: 6px;
        }

        /* =========================================================
           MAIN
        ========================================================= */

        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;

            height: 76px;

            background: rgba(245,247,251,.82);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(230,235,243,.8);

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 36px;

            gap: 20px;
        }

        .back-dashboard {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 44px;
            padding: 5px 17px 5px 7px;
            border: 1px solid rgba(21, 94, 239, .12);
            border-radius: 999px;
            background: linear-gradient(135deg, #ffffff 0%, #f5f8ff 100%);
            color: #344054;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .1px;
            white-space: nowrap;
            text-decoration: none;
            box-shadow: 0 3px 12px rgba(16, 24, 40, .045);
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease, border-color .2s ease;
        }

        .back-dashboard:hover {
            background: linear-gradient(135deg, #eef4ff 0%, #e5edff 100%);
            border-color: rgba(21, 94, 239, .28);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(21, 94, 239, .12);
        }

        .back-dashboard svg {
            width: 30px;
            height: 30px;
            padding: 7px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #eaf1ff;
            color: var(--primary);
            transition: transform .2s ease, background .2s ease;
        }

        .back-dashboard:hover svg {
            background: #dce8ff;
            transform: translateX(-2px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 0;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;

            color: var(--muted);

            font-size: 12px;
            white-space: nowrap;
        }

        .breadcrumb strong {
            color: var(--ink);
            font-weight: 700;
        }

        .breadcrumb-arrow {
            color: #9aa7bd;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-box {
            width: 300px;
            height: 42px;

            background: #fff;
            border: 1px solid var(--border);

            border-radius: 999px;
            box-shadow: var(--shadow-sm);

            display: flex;
            align-items: center;
            gap: 9px;

            padding: 0 16px;

            color: #9aa7bd;

            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .search-box:focus-within {
            border-color: #9dbcf7;
            box-shadow: 0 0 0 4px rgba(37,99,235,.1);
        }

        .search-box svg {
            width: 16px;
            height: 16px;

            flex-shrink: 0;
        }

        .search-box input {
            width: 100%;
            min-width: 0;

            background: transparent;
            border: 0;
            outline: none;

            font-size: 12.5px;
            color: var(--text);
        }

        .search-box input::placeholder {
            color: #9aa7bd;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;

            white-space: nowrap;
        }

        .avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;

            display: grid;
            place-items: center;

            font-size: 11px;
            font-weight: 800;

            box-shadow: 0 6px 14px rgba(37,99,235,.25);
        }

        .profile-name {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--ink);
        }

        .profile-role {
            margin-top: 1px;

            font-size: 11px;
            color: var(--muted);
        }

        .content {
            max-width: 1800px;

            margin: 0 auto;

            padding: 10px 36px 40px;
        }

        /* =========================================================
           PAGE HEADING (HERO)
        ========================================================= */

        .page-heading {
            position: relative;
            overflow: hidden;

            background: linear-gradient(120deg, #1e3a8a 0%, #2563eb 55%, #0ea5a4 120%);
            color: #fff;

            border-radius: 22px;

            padding: 32px 36px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 24px;

            margin: 16px 0 24px;

            box-shadow: var(--shadow-lg);
        }

        .page-heading::before {
            position: absolute;
            top: -120px;
            right: -60px;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,.22), rgba(255,255,255,0) 68%);
            content: "";
        }

        .page-heading::after {
            position: absolute;
            right: 22%;
            bottom: -150px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(14,165,164,.55), rgba(14,165,164,0) 70%);
            content: "";
        }

        .page-heading > * {
            position: relative;
            z-index: 1;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            color: #e6f0ff;
            background: rgba(255,255,255,.16);

            border-radius: 999px;

            padding: 5px 13px;

            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;

            margin-bottom: 12px;
        }

        .eyebrow-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: #7ff0c0;
        }

        .page-heading h1 {
            font-size: clamp(23px, 2.3vw, 30px);
            font-weight: 800;

            letter-spacing: -.6px;

            line-height: 1.25;
        }

        .page-heading p {
            margin-top: 10px;

            max-width: 600px;

            font-size: 13px;
            line-height: 1.7;

            color: #dbe8ff;
        }

        .heading-note {
            text-align: right;
            flex-shrink: 0;
        }

        .heading-note-label {
            font-size: 11px;
            color: #cfe0ff;

            margin-bottom: 4px;
        }

        .heading-note-value {
            font-size: 12.5px;
            font-weight: 700;

            color: #fff;
        }

        .heading-note-value span {
            color: #7ff0c0;
        }

        /* =========================================================
           EXPORT BUTTON
        ========================================================= */

        .export-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            min-height: 44px;
            padding: 0 20px;

            border-radius: 999px;

            background: #fff;
            color: var(--primary);

            border: 0;

            font-size: 12.5px;
            font-weight: 700;

            white-space: nowrap;

            box-shadow: 0 8px 18px rgba(15,31,61,.18);

            transition: transform .18s ease, box-shadow .18s ease;
        }

        .export-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(15,31,61,.25);
        }

        .export-button svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        /* =========================================================
           STAT CARDS
        ========================================================= */

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 16px;

            margin-bottom: 22px;
        }

        .stat-card {
            position: relative;
            overflow: hidden;

            background: var(--white);

            border: 1px solid var(--border);
            border-radius: var(--radius);

            padding: 20px 22px 18px;

            min-width: 0;

            box-shadow: var(--shadow);

            transition: transform .2s ease, box-shadow .2s ease;
        }

        .stat-card::after {
            position: absolute;
            top: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--primary-light);
            opacity: .7;
            content: "";
        }

        .stat-card:nth-child(2)::after { background: var(--green-soft); }
        .stat-card:nth-child(3)::after { background: var(--purple-soft); }
        .stat-card:nth-child(4)::after { background: var(--orange-soft); }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .stat-top {
            position: relative;
            z-index: 1;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 8px;
        }

        .stat-label {
            color: var(--muted);

            font-size: 11.5px;
            font-weight: 700;

            letter-spacing: .4px;

            text-transform: uppercase;
        }

        .stat-icon {
            width: 40px;
            height: 40px;

            display: grid;
            place-items: center;

            border-radius: 12px;

            flex-shrink: 0;

            color: #fff;
        }

        .stat-icon svg {
            width: 19px;
            height: 19px;
        }

        .icon-blue {
            background: linear-gradient(135deg, var(--primary), #5b8def);
            box-shadow: 0 6px 14px rgba(37,99,235,.28);
        }

        .icon-green {
            background: linear-gradient(135deg, var(--green), #35c58c);
            box-shadow: 0 6px 14px rgba(16,163,106,.28);
        }

        .icon-orange {
            background: linear-gradient(135deg, var(--orange), #f4b23f);
            box-shadow: 0 6px 14px rgba(224,138,11,.28);
        }

        .icon-purple {
            background: linear-gradient(135deg, var(--purple), #9a8be6);
            box-shadow: 0 6px 14px rgba(109,91,208,.28);
        }

        .stat-number {
            position: relative;
            z-index: 1;

            font-size: clamp(28px, 2.7vw, 36px);
            font-weight: 800;

            letter-spacing: -1px;

            line-height: 1.05;

            margin: 16px 0 10px;

            color: var(--ink);

            font-variant-numeric: tabular-nums;
        }

        .stat-footer {
            position: relative;
            z-index: 1;

            display: flex;
            align-items: center;

            gap: 7px;

            flex-wrap: wrap;

            color: var(--muted);

            font-size: 11.5px;
        }

        .stat-pill {
            display: inline-block;

            padding: 3px 9px;

            border-radius: 999px;

            font-size: 10.5px;
            font-weight: 700;
        }

        .pill-green {
            color: #0b7d52;
            background: var(--green-soft);
        }

        .pill-orange {
            color: #a8640a;
            background: var(--orange-soft);
        }

        .pill-blue {
            color: var(--primary);
            background: var(--primary-light);
        }

        .pill-purple {
            color: var(--purple);
            background: var(--purple-soft);
        }

        /* =========================================================
           GRID & PANEL
        ========================================================= */

        .dashboard-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1.75fr)
                minmax(280px, .95fr);

            gap: 18px;

            align-items: start;
        }

        .panel {
            background: var(--white);

            border: 1px solid var(--border);
            border-radius: var(--radius);

            overflow: hidden;

            min-width: 0;

            box-shadow: var(--shadow);
        }

        .panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 12px;

            padding: 22px 24px 18px;
        }

        .panel-title {
            font-size: 16px;
            font-weight: 800;

            letter-spacing: -.2px;

            color: var(--ink);
        }

        .panel-description {
            margin-top: 4px;

            color: var(--muted);

            font-size: 12px;
            line-height: 1.6;
        }

        .panel-badge {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            background: var(--primary-light);
            color: var(--primary);

            border-radius: 999px;

            padding: 5px 13px;

            font-size: 11px;
            font-weight: 700;

            white-space: nowrap;
        }

        .panel-badge svg {
            width: 13px;
            height: 13px;
        }

        /* =========================================================
           SECTOR
        ========================================================= */

        .sector-list {
            padding: 2px 24px 22px;
        }

        .sector-row {
            padding: 10px 0 11px;
        }

        .sector-info {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-bottom: 8px;
        }

        .sector-name-wrap {
            display: flex;
            align-items: center;

            gap: 9px;

            min-width: 0;
        }

        .sector-dot {
            width: 9px;
            height: 9px;

            border-radius: 50%;

            flex-shrink: 0;
        }

        .sector-name {
            font-size: 12.5px;
            font-weight: 600;

            overflow-wrap: anywhere;
        }

        .sector-count {
            text-align: right;

            white-space: nowrap;

            flex-shrink: 0;
        }

        .sector-count strong {
            font-size: 12px;
            font-weight: 800;
            color: var(--ink);
        }

        .sector-percent {
            display: inline-block;

            min-width: 46px;

            margin-left: 7px;

            color: var(--muted);

            font-size: 11.5px;

            text-align: right;
        }

        .progress-track {
            height: 10px;

            border-radius: 99px;

            overflow: hidden;

            background: #edf1f8;
        }

        .progress-fill {
            height: 100%;
            min-width: 4px;

            border-radius: 99px;

            transition: width .4s ease;
        }

        /* =========================================================
           METADATA QUALITY
        ========================================================= */

        .quality-list {
            padding: 0 24px 22px;
        }

        .quality-row {
            padding: 13px 0;

            border-bottom: 1px solid #eff2f8;
        }

        .quality-row:last-child {
            border-bottom: 0;
        }

        .quality-top {
            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 10px;

            margin-bottom: 8px;
        }

        .quality-name {
            font-size: 12.5px;
            font-weight: 600;
        }

        .quality-value {
            font-size: 11.5px;
            color: var(--muted);

            white-space: nowrap;
        }

        .quality-value strong {
            color: var(--ink);
            font-weight: 800;
        }

        .quality-track {
            height: 9px;

            background: #edf1f8;

            border-radius: 99px;

            overflow: hidden;
        }

        .quality-fill {
            height: 100%;

            border-radius: 99px;

            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .quality-help {
            margin-top: 6px;

            font-size: 10.5px;

            color: #9aa7bd;
        }

        /* =========================================================
           OPD LIST
        ========================================================= */

        .opd-list {
            padding: 2px 24px 22px;
        }

        .opd-row {
            padding: 10px 0 11px;
        }

        .opd-info {
            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 12px;

            margin-bottom: 8px;
        }

        .opd-name {
            font-size: 12.5px;
            font-weight: 600;

            overflow-wrap: anywhere;
        }

        .opd-count {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--muted);

            white-space: nowrap;
        }

        .opd-track {
            height: 9px;

            background: #edf1f8;

            border-radius: 99px;

            overflow: hidden;
        }

        .opd-fill {
            height: 100%;
            min-width: 4px;

            background: linear-gradient(90deg, var(--purple), #6172f3);

            border-radius: 99px;
        }

        /* =========================================================
           INSIGHT
        ========================================================= */

        .insight-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 14px;

            padding: 0 24px 24px;
        }

        .insight-card {
            border: 1px solid var(--border);

            background: #fff;

            border-radius: 14px;

            padding: 16px 18px;

            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .insight-card:hover {
            border-color: #c9d9f5;
            box-shadow: var(--shadow);
        }

        .insight-label {
            color: var(--muted);

            font-size: 10.5px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .6px;

            margin-bottom: 8px;
        }

        .insight-value {
            font-size: 16px;
            font-weight: 800;

            letter-spacing: -.3px;

            line-height: 1.4;

            color: var(--ink);

            overflow-wrap: anywhere;
        }

        .insight-desc {
            margin-top: 6px;

            color: var(--muted);

            font-size: 11.5px;
            line-height: 1.6;
        }

        /* =========================================================
           PROCESS FLOW
        ========================================================= */

        .process-panel {
            margin-top: 18px;
        }

        .process-list {
            padding: 0 24px 24px;

            display: grid;

            grid-template-columns:
                repeat(6, minmax(0, 1fr));

            gap: 12px;
        }

        .process-step {
            position: relative;

            background: linear-gradient(160deg, #f6f9ff, #f1faf9);

            border: 1px solid #e3ebfa;

            border-radius: 14px;

            padding: 16px 12px;

            text-align: center;

            transition: transform .18s ease, box-shadow .18s ease;
        }

        .process-step:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .process-number {
            width: 30px;
            height: 30px;

            margin: 0 auto 10px;

            display: grid;
            place-items: center;

            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;

            border-radius: 50%;

            font-size: 11px;
            font-weight: 800;

            box-shadow: 0 6px 12px rgba(37,99,235,.25);
        }

        .process-title {
            font-size: 12px;
            font-weight: 700;

            color: var(--ink);
        }

        .process-desc {
            margin-top: 5px;

            font-size: 10.5px;

            line-height: 1.55;

            color: var(--muted);
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            display: flex;

            justify-content: space-between;

            gap: 15px;

            margin-top: 30px;
            padding: 18px 4px 0;

            border-top: 1px solid var(--border);

            color: var(--muted);

            font-size: 11px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1250px) {

            :root {
                --sidebar-width: 228px;
            }

            .content {
                padding: 10px 24px 32px;
            }

            .topbar {
                padding: 0 24px;
            }

            .stats-grid {
                gap: 12px;
            }

            .stat-card {
                padding: 17px;
            }

            .dashboard-grid {
                grid-template-columns:
                    minmax(0, 1.4fr)
                    minmax(270px, 1fr);
            }

            .process-list {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1000px) {

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .search-box {
                width: 220px;
            }

            .process-list {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 650px) {

            :root {
                --sidebar-width: 0px;
            }

            .sidebar {
                position: static;

                width: 100%;

                padding: 12px 12px 4px;

                border-right: 0;

                border-bottom: 1px solid var(--border);
            }

            .brand {
                padding: 0 4px 10px;
            }

            .nav-label {
                padding: 6px 8px 8px;
            }

            .nav-menu {
                padding: 0 0 10px;

                display: grid;

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .nav-link {
                min-height: 42px;

                padding: 6px 10px;

                font-size: 12px;
            }

            .sidebar-bottom {
                display: none;
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                position: static;

                height: auto;

                min-height: 54px;

                padding: 12px 16px;

                background: transparent;

                backdrop-filter: none;

                border: 0;
            }

            .breadcrumb {
                font-size: 11px;
            }

            .topbar-right {
                display: none;
            }

            .content {
                padding: 4px 14px 26px;
            }

            .page-heading {
                padding: 24px 22px;

                margin-top: 6px;

                border-radius: 18px;
            }

            .heading-note {
                display: none;
            }

            .stats-grid {
                gap: 10px;
            }

            .stat-card {
                padding: 15px;
                border-radius: 15px;
            }

            .stat-number {
                font-size: 26px;
            }

            .stat-label {
                font-size: 10px;
            }

            .stat-icon {
                width: 32px;
                height: 32px;
                border-radius: 10px;
            }

            .panel-header {
                padding: 18px;
            }

            .sector-list {
                padding: 0 18px 18px;
            }

            .sector-percent {
                display: none;
            }

            .insight-grid {
                grid-template-columns: 1fr;

                padding: 0 18px 18px;
            }

            .quality-list {
                padding: 0 18px 18px;
            }

            .opd-list {
                padding: 0 18px 18px;
            }

            .process-list {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

                padding: 0 18px 18px;
            }

            .footer {
                flex-direction: column;
                gap: 5px;
            }
        }

        /* =========================================================
           ANALISIS RELASI ANTAR-OPD
        ========================================================= */

        .relation-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin: 0 24px 20px;
        }

        .relation-stat {
            background: linear-gradient(135deg, #f6f9ff, #f1faf9);
            border: 1px solid #e3ebfa;
            border-radius: 14px;
            padding: 16px 18px;
        }

        .relation-stat .label {
            color: var(--muted);
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .relation-stat .value {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -.8px;
            color: var(--ink);
            margin-top: 6px;
            font-variant-numeric: tabular-nums;
        }

        .relation-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 0 24px 20px;
        }

        .relation-toolbar input,
        .relation-toolbar select {
            min-height: 44px;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 0 14px;
            background: #f8faff;
            color: var(--text);
            outline: none;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }

        .relation-toolbar input:focus,
        .relation-toolbar select:focus {
            border-color: #9dbcf7;
            box-shadow: 0 0 0 4px rgba(37,99,235,.1);
            background: #fff;
        }

        .relation-toolbar input {
            flex: 1;
            min-width: 200px;
        }

        .relation-toolbar button,
        .relation-reset {
            border: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), #3b82f6);
            color: #fff;
            padding: 0 20px;
            min-height: 44px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 6px 14px rgba(37,99,235,.22);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .relation-toolbar button:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(37,99,235,.3);
        }

        .relation-reset {
            background: #fff;
            color: var(--text);
            border: 1px solid var(--border);
            box-shadow: none;
        }

        .relation-reset:hover {
            background: #f5f8fd;
            border-color: #d3deef;
        }

        .relation-note {
            margin: 0 24px 18px;
            padding: 13px 16px;
            border: 1px solid #fde4a6;
            border-left: 4px solid #f5b13a;
            background: #fffaed;
            color: #8a4a0c;
            border-radius: 12px;
            line-height: 1.65;
            font-size: 12px;
        }

        .table-wrap {
            overflow-x: auto;
            padding: 0 24px 20px;
        }

        .relation-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 760px;
        }

        .relation-table th,
        .relation-table td {
            text-align: left;
            padding: 14px 14px;
            border-bottom: 1px solid #eff2f8;
            vertical-align: top;
            font-size: 12.5px;
            line-height: 1.6;
        }

        .relation-table th {
            background: #f5f8fd;
            color: var(--muted);
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            white-space: nowrap;
            border-bottom: 0;
        }

        .relation-table th:first-child { border-radius: 12px 0 0 12px; }
        .relation-table th:last-child { border-radius: 0 12px 12px 0; }

        .relation-table tbody tr {
            transition: background .15s ease;
        }

        .relation-table tbody tr:hover {
            background: #f8faff;
        }

        .relation-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .relation-table td strong {
            color: var(--ink);
            font-weight: 700;
        }

        .status-unverified {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--orange-soft);
            color: #a8640a;
            padding: 5px 11px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-unverified::before {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
            content: "";
        }

        .table-pagination {
            padding: 0 24px 22px;
        }

        .table-pagination nav {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
        }

        /* Batasi ikon SVG pagination agar tidak membesar karena CSS global */
        .table-pagination svg,
        .table-pagination nav svg,
        nav[role="navigation"] .table-pagination svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            display: inline-block !important;
            vertical-align: middle;
        }

        .table-pagination nav a,
        .table-pagination nav span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .table-pagination nav svg * { vector-effect: none; }

        .table-pagination a,
        .table-pagination span {
            padding: 8px 13px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            background: #fff;
        }

        .table-pagination a:hover {
            background: #f5f8fd;
            border-color: #c9d9f5;
        }

        .table-pagination [aria-current="page"] span {
            background: linear-gradient(135deg, var(--primary), #3b82f6);
            color: #fff;
            border-color: transparent;
        }

        .empty-state {
            padding: 24px 18px;
            color: var(--muted);
            font-size: 12.5px;
            text-align: center;
        }

        .sector-list .empty-state,
        .opd-list .empty-state {
            border: 1.5px dashed #d5deec;
            border-radius: 14px;
            background: #fafbfe;
        }

        .panel > .empty-state {
            margin: 0 24px 24px;
            border: 1.5px dashed #d5deec;
            border-radius: 14px;
            background: #fafbfe;
        }

        @media (max-width: 650px) {
            .topbar { height: auto; min-height: 76px; padding: 12px 18px; flex-wrap: wrap; }
            .topbar-left { flex-wrap: wrap; gap: 10px; }
            .back-dashboard { min-height: 36px; padding: 0 11px; }
            .back-dashboard span { font-size: 11px; }
            .relation-stats { grid-template-columns: 1fr; margin: 0 18px 16px; }
            .relation-toolbar { padding: 0 18px 16px; }
            .table-wrap { padding: 0 18px 16px; }
            .relation-note { margin: 0 18px 16px; }
            .table-pagination { padding: 0 18px 18px; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; scroll-behavior: auto !important; }
            .stat-card:hover, .export-button:hover, .process-step:hover { transform: none; }
        }

        @media print {
            .sidebar, .topbar-right, .relation-toolbar, .export-button { display: none !important; }
            .main { margin-left: 0; }
            body { background: #fff; }
            .topbar { position: static; background: #fff; backdrop-filter: none; }
            .panel, .stat-card, .page-heading { box-shadow: none; break-inside: avoid; }
        }

    

        /* =========================================================
           MODE HALAMAN ANALISIS TANPA SIDEBAR
           Khusus file halaman Analisis Data ini.
        ========================================================= */
        .sidebar {
            display: none !important;
        }

        .main {
            margin-left: 0 !important;
            width: 100%;
        }

        .content {
            width: 100%;
            max-width: 1800px;
            margin-left: auto;
            margin-right: auto;
        }

    </style>
</head>


<body>

    @php

        $sectorColors = [
            '#155eef',
            '#12b76a',
            '#0e9384',
            '#7f56d9',
            '#f79009',
            '#6172f3',
            '#06aed4',
            '#ee46bc',
        ];

    @endphp


    <!-- =========================================================
         SIDEBAR
    ========================================================== -->

    <aside class="sidebar">

        <a
            href="{{ url('/dashboard') }}"
            class="brand"
        >

            <div class="brand-icon">

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                </svg>

            </div>


            <div>

                <div class="brand-title">
                    Satu Data OPD
                </div>

                <div class="brand-subtitle">
                    Portal Pemetaan Dataset
                </div>

            </div>

        </a>


        <div class="nav-label">
            NAVIGASI UTAMA
        </div>


        <nav class="nav-menu">

            <!-- DASHBOARD -->

            <a
                href="{{ url('/dashboard') }}"
                class="nav-link {{ request()->is('dashboard') || request()->is('/') ? 'active' : '' }}"
            >

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="8" height="8" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="5" rx="1.5"/>
                    <rect x="14" y="11" width="7" height="10" rx="1.5"/>
                    <rect x="3" y="14" width="8" height="7" rx="1.5"/>
                </svg>

                <span>
                    Dashboard
                </span>

            </a>


            <!-- DATASET -->

            <a
                href="{{ url('/dataset') }}"
                class="nav-link {{ request()->is('dataset*') ? 'active' : '' }}"
            >

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <ellipse cx="12" cy="5" rx="8" ry="3"/>
                    <path d="M4 5v14c0 1.7 3.6 3 8 3s8-1.3 8-3V5"/>
                    <path d="M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3"/>
                </svg>

                <span>
                    Dataset
                </span>

            </a>


            <!-- PEMETAAN -->

            <a
                href="{{ url('/pemetaan') }}"
                class="nav-link {{ request()->is('pemetaan') ? 'active' : '' }}"
            >

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="6" rx="1.5"/>
                    <rect x="14" y="15" width="7" height="6" rx="1.5"/>
                    <rect x="3" y="15" width="7" height="6" rx="1.5"/>
                    <path d="M6.5 9v3h11v3M17.5 12h-11"/>
                </svg>

                <span>
                    Pemetaan Data
                </span>

            </a>


            <!-- KLASIFIKASI -->

            <a
                href="{{ url('/dataset') }}"
                class="nav-link {{ request()->is('dataset*') ? 'active' : '' }}"
            >

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 12 2 2 4-4"/>
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 3v2M21 12h-2M12 21v-2M3 12h2"/>
                </svg>

                <span>
                    Klasifikasi
                </span>

            </a>


            <!-- ANALISIS -->

            <a
                href="{{ url('/analisis') }}"
                class="nav-link {{ request()->is('analisis') ? 'active' : '' }}"
            >

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18"/>
                    <path d="m7 14 4-4 4 3 5-7"/>
                </svg>

                <span>
                    Analisis Data
                </span>

                <span class="nav-tag">
                    Dasar
                </span>

            </a>

        </nav>


        <div class="sidebar-bottom">

            <div class="version-card">

                <div class="version-title">

                    <span class="version-dot"></span>

                    Versi Prototipe v1.0

                </div>

                <div class="version-desc">

                    Sistem klasifikasi dan pemetaan dataset OPD
                    Pemerintah Kota Surakarta.

                </div>

            </div>

        </div>

    </aside>


    <!-- =========================================================
         MAIN
    ========================================================== -->

    <main class="main">


        <!-- TOPBAR -->

        <header class="topbar">

            <div class="topbar-left">

                <a href="{{ url('/dashboard') }}" class="back-dashboard" aria-label="Kembali ke Dashboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M19 12H5" />
                        <path d="m12 19-7-7 7-7" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <div class="breadcrumb">

                <span>
                    Satu Data OPD
                </span>

                <span class="breadcrumb-arrow">
                    ›
                </span>

                <strong>
                    Analisis Data
                </strong>

                </div>

            </div>


            <div class="topbar-right">

                <label class="search-box">

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m16 16 4 4"/>
                    </svg>

                    <input
                        type="search"
                        id="analysisSearch"
                        placeholder="Cari analisis atau OPD..."
                        aria-label="Cari analisis atau OPD"
                    >

                </label>


                <div class="profile">

                    <div class="avatar">
                        OPD
                    </div>

                    <div>

                        <div class="profile-name">
                            Administrator
                        </div>

                        <div class="profile-role">
                            Pengelola Dataset
                        </div>

                    </div>

                </div>

            </div>

        </header>


        <div class="content">


            <!-- =================================================
                 PAGE HEADING
            ================================================== -->

            <section class="page-heading">

                <div>

                    <div class="eyebrow">

                        <span class="eyebrow-dot"></span>

                        Analisis Data

                    </div>


                    <h1>
                        Analisis Dataset OPD
                    </h1>


                    <p>
                        Ringkasan analisis kualitas, distribusi,
                        klasifikasi, dan pemetaan dataset
                        Organisasi Perangkat Daerah.
                    </p>

                </div>


                <div class="heading-note">

                    <a
                        href="{{ route('analisis.export') }}"
                        class="export-button"
                    >

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3v12"/>
                            <path d="m7 10 5 5 5-5"/>
                            <path d="M5 21h14"/>
                        </svg>

                        Unduh Hasil Analisis

                    </a>

                    <div
                        class="heading-note-label"
                        style="margin-top:10px"
                    >
                        Status Analisis
                    </div>

                    <div class="heading-note-value">
                        <span>● Aktif</span>
                    </div>

                    <div
                        class="heading-note-label"
                        style="margin-top:7px"
                    >
                        Analisis berdasarkan data database
                    </div>

                </div>

            </section>


            <!-- =================================================
                 KPI
            ================================================== -->

            <section class="stats-grid">


                <!-- TOTAL -->

                <article class="stat-card">

                    <div class="stat-top">

                        <div class="stat-label">
                            Total Dataset
                        </div>

                        <div class="stat-icon icon-blue">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <path d="M14 2v6h6M8 13h8M8 17h8"/>
                            </svg>

                        </div>

                    </div>


                    <div class="stat-number">

                        {{ number_format($totalDataset, 0, ',', '.') }}

                    </div>


                    <div class="stat-footer">

                        Seluruh dataset yang dianalisis

                    </div>

                </article>


                <!-- TERKLASIFIKASI -->

                <article class="stat-card">

                    <div class="stat-top">

                        <div class="stat-label">
                            Terklasifikasi
                        </div>

                        <div class="stat-icon icon-green">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="m8 12 2.5 2.5L16 9"/>
                            </svg>

                        </div>

                    </div>


                    <div class="stat-number">

                        {{ number_format($totalTerklasifikasi, 0, ',', '.') }}

                    </div>


                    <div class="stat-footer">

                        <span class="stat-pill pill-green">

                            {{ $persentaseTerklasifikasi }}%

                        </span>

                        Dataset berhasil diklasifikasi

                    </div>

                </article>


                <!-- TERPETAKAN -->

                <article class="stat-card">

                    <div class="stat-top">

                        <div class="stat-label">
                            Terpetakan
                        </div>

                        <div class="stat-icon icon-purple">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                                <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                                <path d="M10 6.5h4M17.5 10v4"/>
                            </svg>

                        </div>

                    </div>


                    <div class="stat-number">

                        {{ number_format($totalTerpetakan, 0, ',', '.') }}

                    </div>


                    <div class="stat-footer">

                        <span class="stat-pill pill-purple">

                            {{ $persentaseTerpetakan }}%

                        </span>

                        Dataset sudah dipetakan

                    </div>

                </article>


                <!-- KELENGKAPAN -->

                <article class="stat-card">

                    <div class="stat-top">

                        <div class="stat-label">
                            Kelengkapan Metadata
                        </div>

                        <div class="stat-icon icon-orange">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M8 12h8M12 8v8"/>
                            </svg>

                        </div>

                    </div>


                    <div class="stat-number">

                        {{ $persentaseLengkap }}%

                    </div>


                    <div class="stat-footer">

                        <span class="stat-pill pill-orange">

                            {{ number_format($datasetPerluDilengkapi, 0, ',', '.') }}

                        </span>

                        Dataset perlu dilengkapi

                    </div>

                </article>

            </section>


            <!-- =================================================
                 DISTRIBUSI SEKTOR + KUALITAS DATA
            ================================================== -->

            <section class="dashboard-grid">


                <!-- DISTRIBUSI SEKTOR -->

                <article class="panel">

                    <div class="panel-header">

                        <div>

                            <h2 class="panel-title">
                                Distribusi Dataset Berdasarkan Sektor
                            </h2>

                            <p class="panel-description">
                                Sebaran dataset berdasarkan hasil
                                klasifikasi sektor.
                            </p>

                        </div>


                        <div class="panel-badge">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="3"/>
                                <path d="M8 16V11M12 16V7M16 16v-3"/>
                            </svg>

                            {{ $totalSektor }} Sektor

                        </div>

                    </div>


                    <div class="sector-list">

                        @forelse ($distribusiSektor as $sektor)

                            @php

                                $warna =
                                    $sectorColors[
                                        $loop->index %
                                        count($sectorColors)
                                    ];

                                $lebarBar =
                                    $maksDatasetSektor > 0
                                    ? (
                                        $sektor->datasets_count /
                                        $maksDatasetSektor
                                    ) * 100
                                    : 0;

                                $persentase =
                                    $totalDataset > 0
                                    ? round(
                                        (
                                            $sektor->datasets_count /
                                            $totalDataset
                                        ) * 100,
                                        1
                                    )
                                    : 0;

                            @endphp


                            <div class="sector-row">

                                <div class="sector-info">

                                    <div class="sector-name-wrap">

                                        <span
                                            class="sector-dot"
                                            style="background: {{ $warna }}"
                                        ></span>

                                        <span class="sector-name">

                                            {{ $sektor->nama_sektor }}

                                        </span>

                                    </div>


                                    <div class="sector-count">

                                        <strong>

                                            {{
                                                number_format(
                                                    $sektor->datasets_count,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}

                                            dataset

                                        </strong>


                                        <span class="sector-percent">

                                            {{ $persentase }}%

                                        </span>

                                    </div>

                                </div>


                                <div class="progress-track">

                                    <div
                                        class="progress-fill"
                                        style="
                                            width: {{ $lebarBar }}%;
                                            background: {{ $warna }}
                                        "
                                    ></div>

                                </div>

                            </div>

                        @empty

                            <div class="empty-state">

                                Belum ada data sektor yang tersedia.

                            </div>

                        @endforelse

                    </div>

                </article>


                <!-- KUALITAS METADATA -->

                <article class="panel">

                    <div class="panel-header">

                        <div>

                            <h2 class="panel-title">
                                Kualitas Metadata
                            </h2>

                            <p class="panel-description">
                                Persentase kelengkapan atribut
                                metadata dataset.
                            </p>

                        </div>


                        <div class="panel-badge">
                            Analisis
                        </div>

                    </div>


                    <div class="quality-list">


                        @php

                            $namaField = [
                                'deskripsi_data' => 'Deskripsi Data',
                                'tujuan_pengumpulan_data' => 'Tujuan Pengumpulan Data',
                                'format_data_saat_ini' => 'Format Data Saat Ini',
                                'frekuensi_update' => 'Frekuensi Update',
                            ];

                        @endphp


                        @foreach ($namaField as $field => $label)

                            @php

                                $kosong =
                                    $fieldKosong[$field] ?? 0;

                                $lengkap =
                                    max(
                                        0,
                                        $totalDataset - $kosong
                                    );

                                $persentase =
                                    $totalDataset > 0
                                    ? round(
                                        (
                                            $lengkap /
                                            $totalDataset
                                        ) * 100,
                                        1
                                    )
                                    : 0;

                            @endphp


                            <div class="quality-row">

                                <div class="quality-top">

                                    <span class="quality-name">

                                        {{ $label }}

                                    </span>


                                    <span class="quality-value">

                                        <strong>
                                            {{ $persentase }}%
                                        </strong>

                                        lengkap

                                    </span>

                                </div>


                                <div class="quality-track">

                                    <div
                                        class="quality-fill"
                                        style="
                                            width: {{ $persentase }}%
                                        "
                                    ></div>

                                </div>


                                <div class="quality-help">

                                    {{ number_format($kosong, 0, ',', '.') }}
                                    dataset belum memiliki data

                                </div>

                            </div>

                        @endforeach

                    </div>

                </article>

            </section>


            <!-- =================================================
                 DISTRIBUSI OPD
            ================================================== -->

            <section
                class="panel"
                style="margin-top:18px;"
            >

                <div class="panel-header">

                    <div>

                        <h2 class="panel-title">
                            Distribusi Dataset per OPD
                        </h2>

                        <p class="panel-description">
                            OPD dengan jumlah dataset terbanyak
                            berdasarkan data yang tersimpan.
                        </p>

                    </div>


                    <div class="panel-badge">

                        Top {{ $distribusiOpd->count() }}

                    </div>

                </div>


                <div class="opd-list">

                    @php

                        $maksDatasetOpd =
                            max(
                                1,
                                (int) $distribusiOpd
                                    ->max('datasets_count')
                            );

                    @endphp


                    @forelse ($distribusiOpd as $opd)

                        @php

                            $persentaseOpd =
                                (
                                    $opd->datasets_count /
                                    $maksDatasetOpd
                                ) * 100;

                        @endphp


                        <div class="opd-row">

                            <div class="opd-info">

                                <span class="opd-name">

                                    {{ $opd->nama_opd }}

                                </span>


                                <span class="opd-count">

                                    {{
                                        number_format(
                                            $opd->datasets_count,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                    dataset

                                </span>

                            </div>


                            <div class="opd-track">

                                <div
                                    class="opd-fill"
                                    style="
                                        width: {{ $persentaseOpd }}%
                                    "
                                ></div>

                            </div>

                        </div>

                    @empty

                        <div class="empty-state">

                            Belum ada data OPD yang tersedia.

                        </div>

                    @endforelse

                </div>

            </section>


            <!-- =================================================
                 INSIGHT ANALISIS
            ================================================== -->

            <section
                class="panel"
                style="margin-top:18px;"
            >

                <div class="panel-header">

                    <div>

                        <h2 class="panel-title">
                            Insight Analisis
                        </h2>

                        <p class="panel-description">
                            Ringkasan temuan berdasarkan distribusi
                            dan kondisi dataset.
                        </p>

                    </div>


                    <div class="panel-badge">

                        Ringkasan

                    </div>

                </div>


                <div class="insight-grid">


                    <!-- SEKTOR TERBANYAK -->

                    <div class="insight-card">

                        <div class="insight-label">
                            Sektor Terbanyak
                        </div>


                        <div class="insight-value">

                            @if ($sektorTerbanyak)

                                {{ $sektorTerbanyak->nama_sektor }}

                            @else

                                Belum tersedia

                            @endif

                        </div>


                        <div class="insight-desc">

                            @if ($sektorTerbanyak)

                                {{
                                    number_format(
                                        $sektorTerbanyak->datasets_count,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                                dataset berada pada sektor ini.

                            @else

                                Belum ada data sektor.

                            @endif

                        </div>

                    </div>


                    <!-- OPD TERBANYAK -->

                    <div class="insight-card">

                        <div class="insight-label">
                            OPD Dataset Terbanyak
                        </div>


                        <div class="insight-value">

                            @if ($opdTerbanyak)

                                {{ $opdTerbanyak->nama_opd }}

                            @else

                                Belum tersedia

                            @endif

                        </div>


                        <div class="insight-desc">

                            @if ($opdTerbanyak)

                                {{
                                    number_format(
                                        $opdTerbanyak->datasets_count,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                                dataset tercatat dari OPD ini.

                            @else

                                Belum ada data OPD.

                            @endif

                        </div>

                    </div>


                    <!-- DATA PERLU DILENGKAPI -->

                    <div class="insight-card">

                        <div class="insight-label">
                            Metadata Perlu Dilengkapi
                        </div>


                        <div class="insight-value">

                            {{
                                number_format(
                                    $datasetPerluDilengkapi,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}

                            dataset

                        </div>


                        <div class="insight-desc">

                            Dataset masih memiliki satu atau
                            lebih atribut metadata yang kosong.

                        </div>

                    </div>


                    <!-- BELUM KLASIFIKASI -->

                    <div class="insight-card">

                        <div class="insight-label">
                            Belum Diklasifikasi
                        </div>


                        <div class="insight-value">

                            {{
                                number_format(
                                    $totalBelumTerklasifikasi,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}

                            dataset

                        </div>


                        <div class="insight-desc">

                            Dataset yang masih membutuhkan
                            proses pemeriksaan klasifikasi.

                        </div>

                    </div>

                </div>

            </section>



            <!-- =================================================
                 ANALISIS RELASI ANTAR-OPD
            ================================================== -->
            <section class="panel" style="margin-top:18px;">
                <div class="panel-header">
                    <div>
                        <h2 class="panel-title">Analisis Relasi Antar-OPD</h2>
                        <p class="panel-description">
                            Kandidat dataset dan keterkaitan OPD berdasarkan tabel relasi pendukung yang telah diimpor.
                        </p>
                    </div>
                    <div class="panel-badge">Relasi Data</div>
                </div>

                @if (!$relasiTersedia)
                    <div class="empty-state">
                        Tabel <strong>relasi_pendukung_sumber</strong> belum ditemukan. Pastikan tabel staging/sumber sudah dibuat dan data relasi sudah diimpor.
                    </div>
                @else
                    <div class="relation-stats">
                        <div class="relation-stat">
                            <div class="label">Catatan Relasi</div>
                            <div class="value">{{ number_format($totalCatatanRelasi, 0, ',', '.') }}</div>
                        </div>
                        <div class="relation-stat">
                            <div class="label">Kandidat Dataset (pemilik + nama)</div>
                            <div class="value">{{ number_format($totalKandidatBerulang, 0, ',', '.') }}</div>
                        </div>
                        <div class="relation-stat">
                            <div class="label">OPD Terkait Tercatat</div>
                            <div class="value">{{ number_format($totalOpdTerkait, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="relation-note">
                        <strong>Catatan interpretasi:</strong> angka di bawah adalah catatan/keterkaitan yang tercatat di sumber.
                        Ini belum membuktikan bahwa OPD terkait benar-benar menggunakan dataset, dan kesamaan nama belum otomatis berarti duplikasi.
                        Verifikasi dengan pemilik data diperlukan sebelum menyimpulkan data master atau duplikat.
                    </div>

                    <form method="GET" action="{{ url('/analisis') }}" class="relation-toolbar">
                        <input type="search" name="q" value="{{ $kataKunciRelasi }}" placeholder="Cari nama dataset atau OPD...">
                        <select name="opd_terkait" aria-label="Filter OPD terkait">
                            <option value="">Semua OPD terkait</option>
                            @foreach ($opsiOpdTerkait as $opsi)
                                <option value="{{ $opsi->kode_opd_terkait_sumber }}" {{ $filterOpdTerkait === $opsi->kode_opd_terkait_sumber ? 'selected' : '' }}>
                                    {{ $opsi->nama_opd_terkait }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit">Terapkan Filter</button>
                        <a class="relation-reset" href="{{ url('/analisis') }}">Reset</a>
                    </form>

                    <div class="table-wrap">
                        <table class="relation-table">
                            <thead>
                                <tr>
                                    <th>Dataset sumber</th>
                                    <th>OPD pemilik</th>
                                    <th>OPD terkait tercatat</th>
                                    <th>Catatan</th>
                                    <th>Status bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kandidatRelasi as $kandidat)
                                    <tr>
                                        <td>
                                            <strong>{{ $kandidat->nama_data_sumber }}</strong>
                                            @if (!empty($kandidat->dasar_relasi))
                                                <div style="color:var(--muted);margin-top:4px;">Dasar relasi: {{ \Illuminate\Support\Str::limit($kandidat->dasar_relasi, 180) }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $kandidat->nama_opd_pemilik }}<div style="color:var(--muted);">{{ $kandidat->kode_opd_pemilik_sumber }}</div></td>
                                        <td>{{ $kandidat->daftar_opd_terkait ?: 'Belum tercatat' }}<div style="color:var(--muted);margin-top:4px;">{{ $kandidat->jumlah_opd_terkait }} OPD terkait</div></td>
                                        <td>{{ number_format($kandidat->jumlah_catatan, 0, ',', '.') }}</td>
                                        <td><span class="status-unverified">Belum diverifikasi</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="empty-state">Tidak ada kandidat yang cocok dengan pencarian/filter.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($kandidatRelasi instanceof \Illuminate\Contracts\Pagination\Paginator || $kandidatRelasi instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                        <div class="table-pagination">{{ $kandidatRelasi->links() }}</div>
                    @endif

                    <div class="panel-header" style="border-top:1px solid var(--border);">
                        <div>
                            <h2 class="panel-title">Peringkat OPD yang Paling Sering Tercatat sebagai OPD Terkait</h2>
                            <p class="panel-description">Diurutkan berdasarkan jumlah OPD pemilik yang berbeda, kemudian jumlah kandidat dataset dan catatan relasi.</p>
                        </div>
                    </div>
                    <div class="table-wrap">
                        <table class="relation-table">
                            <thead>
                                <tr><th>OPD terkait</th><th>OPD pemilik berbeda</th><th>Kandidat dataset</th><th>Catatan relasi</th></tr>
                            </thead>
                            <tbody>
                                @forelse ($peringkatOpdTerkait as $peringkat)
                                    <tr>
                                        <td><strong>{{ $peringkat->nama_opd_terkait }}</strong><div style="color:var(--muted);">{{ $peringkat->kode_opd_terkait_sumber }}</div></td>
                                        <td>{{ number_format($peringkat->jumlah_opd_pemilik, 0, ',', '.') }}</td>
                                        <td>{{ number_format($peringkat->jumlah_kandidat_dataset, 0, ',', '.') }}</td>
                                        <td>{{ number_format($peringkat->jumlah_catatan_relasi, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="empty-state">Belum ada catatan relasi yang dapat dirangking.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            <!-- =================================================
                 KANDIDAT DATA MASTER DAN NAMA MIRIP
            ================================================== -->
            @if ($relasiTersedia)
                <section class="panel" style="margin-top:18px;">
                    <div class="panel-header">
                        <div>
                            <h2 class="panel-title">Kandidat Dataset Master</h2>
                            <p class="panel-description">Dataset yang tercatat terkait dengan dua atau lebih OPD. Ini kandidat untuk ditinjau, bukan penetapan master secara otomatis.</p>
                        </div>
                        <div class="panel-badge">Perlu Verifikasi</div>
                    </div>
                    <div class="table-wrap">
                        <table class="relation-table">
                            <thead><tr><th>Dataset kandidat</th><th>OPD pemilik</th><th>OPD terkait tercatat</th><th>Jumlah OPD</th><th>Catatan</th></tr></thead>
                            <tbody>
                                @forelse ($kandidatMaster as $master)
                                    <tr>
                                        <td><strong>{{ $master->nama_data_sumber }}</strong></td>
                                        <td>{{ $master->nama_opd_pemilik }}<div style="color:var(--muted);">{{ $master->kode_opd_pemilik_sumber }}</div></td>
                                        <td>{{ $master->daftar_opd_terkait ?: 'Belum tercatat' }}</td>
                                        <td>{{ number_format($master->jumlah_opd_terkait, 0, ',', '.') }}</td>
                                        <td>{{ number_format($master->jumlah_catatan, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="empty-state">Belum ada kandidat dengan keterkaitan ke minimal dua OPD.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="relation-note" style="margin-top:14px;">
                        <strong>Interpretasi:</strong> jumlah OPD terkait menunjukkan banyaknya nama OPD yang tercatat di sumber. Konfirmasi pemilik, definisi, periode, dan isi data sebelum menetapkannya sebagai dataset master.
                    </div>
                </section>

                <section class="panel" style="margin-top:18px;">
                    <div class="panel-header">
                        <div>
                            <h2 class="panel-title">Kandidat Duplikat Berdasarkan Kesamaan Nama</h2>
                            <p class="panel-description">Nama dataset yang sama setelah spasi dan huruf besar/kecil dinormalisasi, tetapi tercatat pada beberapa OPD pemilik.</p>
                        </div>
                        <div class="panel-badge">Perlu Pemeriksaan</div>
                    </div>
                    <div class="relation-note">
                        Kesamaan nama saja tidak membuktikan duplikasi. Periksa definisi, variabel, cakupan wilayah, periode, satuan, dan sumber datanya.
                    </div>
                    <div class="table-wrap">
                        <table class="relation-table">
                            <thead><tr><th>Nama dataset ternormalisasi</th><th>OPD pemilik tercatat</th><th>Jumlah OPD pemilik</th><th>Jumlah catatan</th></tr></thead>
                            <tbody>
                                @forelse ($kandidatDuplikat as $duplikat)
                                    <tr>
                                        <td>
                                            <strong><a style="color:var(--primary);text-decoration:underline;text-underline-offset:3px;" href="{{ url('/analisis') . '?detail_duplikat=' . urlencode($duplikat->nama_data_normal) . '#detail-duplikat' }}">{{ $duplikat->nama_data_sumber }}</a></strong>
                                            <div style="color:var(--muted);font-size:10px;margin-top:4px;">Klik untuk melihat detail</div>
                                        </td>
                                        <td>{{ $duplikat->daftar_opd_pemilik ?: 'Tidak tercatat' }}</td>
                                        <td>{{ number_format($duplikat->jumlah_opd_pemilik, 0, ',', '.') }}</td>
                                        <td>{{ number_format($duplikat->jumlah_catatan, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="empty-state">Belum ditemukan nama dataset yang sama pada beberapa OPD pemilik.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (!empty($detailNamaDuplikat))
                        <section class="panel" id="detail-duplikat" style="margin:0 20px 20px;border:1px solid var(--border);box-shadow:none;">
                            <div class="panel-header" style="padding:16px 18px;">
                                <div>
                                    <h3 class="panel-title">Detail Kandidat Duplikat</h3>
                                    <p class="panel-description">{{ $detailNamaDuplikat }}</p>
                                </div>
                                <a class="relation-reset" style="text-decoration:none;" href="{{ url('/analisis') }}#detail-duplikat">Tutup detail</a>
                            </div>
                            <div class="relation-note">Setiap baris adalah catatan relasi dari sumber. Catatan ini belum membuktikan bahwa OPD terkait benar-benar menggunakan dataset atau bahwa isi dataset duplikat.</div>
                            <div class="table-wrap">
                                <table class="relation-table">
                                    <thead><tr><th>OPD pemilik</th><th>Nama dataset pada sumber</th><th>OPD terkait tercatat</th><th>Dasar relasi</th><th>Status bukti</th></tr></thead>
                                    <tbody>
                                        @forelse ($detailDuplikat as $detail)
                                            <tr>
                                                <td><strong>{{ $detail->nama_opd_pemilik ?: 'Tidak tercatat' }}</strong><div style="color:var(--muted);">{{ $detail->kode_opd_pemilik_sumber }}</div></td>
                                                <td>{{ $detail->nama_data_sumber }}</td>
                                                <td>{{ $detail->nama_opd_terkait ?: 'Tidak tercatat' }}<div style="color:var(--muted);">{{ $detail->kode_opd_terkait_sumber }}</div></td>
                                                <td>{{ $detail->dasar_relasi ?: 'Tidak dicantumkan' }}</td>
                                                <td><span class="status-unverified">{{ $detail->status_bukti ?: 'Belum diverifikasi' }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="empty-state">Tidak ada detail untuk nama dataset tersebut.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($detailDuplikat instanceof \Illuminate\Contracts\Pagination\Paginator || $detailDuplikat instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                                <div class="table-pagination">{{ $detailDuplikat->links() }}</div>
                            @endif
                        </section>
                    @endif
                </section>
            @endif

            <!-- =================================================
                 ALUR PENGOLAHAN DATA
            ================================================== -->

            <section
                class="panel process-panel"
            >

                <div class="panel-header">

                    <div>

                        <h2 class="panel-title">
                            Alur Pengolahan Data
                        </h2>

                        <p class="panel-description">
                            Tahapan pengolahan dataset sebelum
                            menghasilkan analisis.
                        </p>

                    </div>


                    <div class="panel-badge">
                        Proses Sistem
                    </div>

                </div>


                <div class="process-list">


                    <div class="process-step">

                        <div class="process-number">
                            1
                        </div>

                        <div class="process-title">
                            Import Dataset
                        </div>

                        <div class="process-desc">
                            Data OPD dimasukkan ke dalam sistem.
                        </div>

                    </div>


                    <div class="process-step">

                        <div class="process-number">
                            2
                        </div>

                        <div class="process-title">
                            Cleaning
                        </div>

                        <div class="process-desc">
                            Pemeriksaan dan penanganan data.
                        </div>

                    </div>


                    <div class="process-step">

                        <div class="process-number">
                            3
                        </div>

                        <div class="process-title">
                            Standardisasi
                        </div>

                        <div class="process-desc">
                            Penyamaan format dan struktur data.
                        </div>

                    </div>


                    <div class="process-step">

                        <div class="process-number">
                            4
                        </div>

                        <div class="process-title">
                            Klasifikasi
                        </div>

                        <div class="process-desc">
                            Dataset dikelompokkan berdasarkan sektor.
                        </div>

                    </div>


                    <div class="process-step">

                        <div class="process-number">
                            5
                        </div>

                        <div class="process-title">
                            Pemetaan
                        </div>

                        <div class="process-desc">
                            Dataset dihubungkan dengan OPD dan sektor.
                        </div>

                    </div>


                    <div class="process-step">

                        <div class="process-number">
                            6
                        </div>

                        <div class="process-title">
                            Analisis
                        </div>

                        <div class="process-desc">
                            Hasil pengolahan diringkas menjadi informasi.
                        </div>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 FOOTER
            ================================================== -->

            <footer class="footer">

                <span>
                    Satu Data OPD · Portal Pemetaan Dataset
                </span>

                <span>
                    Prototipe Sistem · {{ date('Y') }}
                </span>

            </footer>

        </div>

    </main>


    <!-- =========================================================
         SEARCH
    ========================================================== -->

    <script>

        const searchInput =
            document.getElementById('analysisSearch');


        if (searchInput) {

            searchInput.addEventListener(
                'input',
                function () {

                    const keyword =
                        this.value
                            .toLowerCase()
                            .trim();


                    document
                        .querySelectorAll(
                            '.panel, .stat-card'
                        )
                        .forEach(
                            function (item) {

                                if (!keyword) {

                                    item.style.display = '';

                                    return;

                                }


                                item.style.display =
                                    item.textContent
                                        .toLowerCase()
                                        .includes(keyword)
                                        ? ''
                                        : 'none';

                            }
                        );

                }
            );

        }

    </script>

</body>

</html>