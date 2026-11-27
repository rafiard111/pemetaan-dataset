<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Satu Data OPD - Pemerintah Kota Surakarta</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"> 
 
    <style> 
        :root { 
            --primary: #155eef; 
            --primary-dark: #1249bd; 
            --primary-light: #eff4ff; 
            --bg: #f5f7fb; 
            --white: #ffffff; 
            --text: #182230; 
            --muted: #667085; 
            --border: #e4e7ec; 
            --green: #079455; 
            --orange: #dc6803; 
            --sidebar-width: 248px; 
        } 
 
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        } 
 
        body { 
            font-family: 'Inter', Arial, sans-serif; 
            background: var(--bg); 
            color: var(--text); 
            font-size: 13px; 
        } 
 
        a { 
            text-decoration: none; 
            color: inherit; 
        } 
 
        button, 
        input { 
            font: inherit; 
        } 
 
        /* SIDEBAR */ 
 
        .sidebar { 
            position: fixed; 
            inset: 0 auto 0 0; 
            width: var(--sidebar-width); 
            background: var(--white); 
            border-right: 1px solid var(--border); 
            display: flex; 
            flex-direction: column; 
            z-index: 20; 
        } 
 
        .brand { 
            height: 76px; 
            padding: 0 20px; 
            display: flex; 
            align-items: center; 
            gap: 11px; 
            border-bottom: 1px solid #f0f2f5; 
        } 
 
        .brand-icon { 
            width: 38px; 
            height: 38px; 
            background: var(--primary); 
            color: white; 
            display: grid; 
            place-items: center; 
            border-radius: 10px; 
            flex-shrink: 0; 
        } 
 
        .brand-icon svg { 
            width: 22px; 
            height: 22px; 
        } 
 
        .brand-title { 
            font-size: 15px; 
            font-weight: 800; 
            letter-spacing: -.5px; 
        } 
 
        .brand-subtitle { 
            font-size: 10px; 
            color: var(--muted); 
            margin-top: 4px; 
        } 
 
        .nav-label { 
            color: #98a2b3; 
            font-size: 10px; 
            font-weight: 700; 
            letter-spacing: .8px; 
            padding: 28px 20px 12px; 
        } 
 
        .nav-menu { 
            padding: 0 12px; 
            display: flex; 
            flex-direction: column; 
            gap: 5px; 
        } 
 
        .nav-link { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            min-height: 42px; 
            padding: 0 13px; 
            border-radius: 8px; 
            color: #475467; 
            font-weight: 500; 
            transition: .2s; 
        } 
 
        .nav-link svg { 
            width: 18px; 
            height: 18px; 
            flex-shrink: 0; 
        } 
 
        .nav-link:hover { 
            background: #f2f4f7; 
            color: var(--primary); 
        } 
 
        .nav-link.active { 
            background: var(--primary); 
            color: white; 
            font-weight: 600; 
            box-shadow: 0 2px 5px #155eef25; 
        } 
 
        .nav-tag { 
            margin-left: auto; 
            font-size: 9px; 
            color: #667085; 
            background: #f2f4f7; 
            padding: 3px 6px; 
            border-radius: 4px; 
        } 
 
        .nav-link.active .nav-tag { 
            color: #1849a9; 
            background: white; 
        } 
 
        .sidebar-bottom { 
            margin-top: auto; 
            padding: 14px; 
            border-top: 1px solid var(--border); 
        } 
 
        .version-card { 
            background: #f8faff; 
            border: 1px solid #e4eaff; 
            border-radius: 9px; 
            padding: 13px; 
        } 
 
        .version-title { 
            font-size: 11px; 
            font-weight: 700; 
            margin-bottom: 5px; 
        } 
 
        .version-desc { 
            font-size: 10px; 
            line-height: 1.6; 
            color: var(--muted); 
        } 
 
        .version-dot { 
            display: inline-block; 
            width: 7px; 
            height: 7px; 
            border-radius: 50%; 
            background: #12b76a; 
            margin-right: 5px; 
        } 
 
        /* MAIN */ 
 
        .main { 
            margin-left: var(--sidebar-width); 
            min-height: 100vh; 
        } 
 
        .topbar { 
            height: 68px; 
            background: var(--white); 
            border-bottom: 1px solid var(--border); 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            padding: 0 30px; 
            gap: 20px; 
        } 
 
        .breadcrumb { 
            display: flex; 
            align-items: center; 
            gap: 9px; 
            color: var(--muted); 
            font-size: 11px; 
            white-space: nowrap; 
        } 
 
        .breadcrumb strong { 
            color: #344054; 
            font-weight: 600; 
        } 
 
        .breadcrumb-arrow { 
            color: #98a2b3; 
        } 
 
        .topbar-right { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
        } 
 
        .search-box { 
            width: 260px; 
            height: 36px; 
            background: #f9fafb; 
            border: 1px solid var(--border); 
            border-radius: 7px; 
            display: flex; 
            align-items: center; 
            gap: 9px; 
            padding: 0 11px; 
            color: #98a2b3; 
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
            font-size: 11px; 
            color: var(--text); 
        } 
 
        .search-box input::placeholder { 
            color: #98a2b3; 
        } 
 
        .profile { 
            display: flex; 
            align-items: center; 
            gap: 9px; 
            white-space: nowrap; 
        } 
 
        .avatar { 
            width: 34px; 
            height: 34px; 
            border-radius: 50%; 
            background: #dbeafe; 
            color: #1849a9; 
            display: grid; 
            place-items: center; 
            font-size: 11px; 
            font-weight: 800; 
        } 
 
        .profile-name { 
            font-size: 11px; 
            font-weight: 700; 
        } 
 
        .profile-role { 
            margin-top: 4px; 
            font-size: 10px; 
            color: var(--muted); 
        } 
 
        .content { 
            max-width: 1800px; 
            margin: 0 auto; 
            padding: 26px 30px 32px; 
        } 
 
        /* PAGE HEADING */ 
 
        .page-heading { 
            background: linear-gradient(110deg, #ffffff 0%, #f1f5ff 100%); 
            border: 1px solid var(--border); 
            border-radius: 10px; 
            padding: 21px 23px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            gap: 20px; 
            margin-bottom: 20px; 
        } 
 
        .eyebrow { 
            display: inline-flex; 
            align-items: center; 
            gap: 7px; 
            color: #1849a9; 
            background: #eaf1ff; 
            border: 1px solid #dbe6ff; 
            border-radius: 5px; 
            padding: 5px 8px; 
            font-size: 10px; 
            font-weight: 600; 
            margin-bottom: 10px; 
        } 
 
        .eyebrow-dot { 
            width: 6px; 
            height: 6px; 
            border-radius: 50%; 
            background: var(--primary); 
        } 
 
        .page-heading h1 { 
            font-size: 23px; 
            font-weight: 800; 
            letter-spacing: -.8px; 
            line-height: 1.4; 
        } 
 
        .page-heading p { 
            margin-top: 6px; 
            font-size: 11px; 
            line-height: 1.7; 
            color: var(--muted); 
        } 
 
        .heading-note { 
            text-align: right; 
            flex-shrink: 0; 
        } 
 
        .heading-note-label { 
            font-size: 10px; 
            color: var(--muted); 
            margin-bottom: 6px; 
        } 
 
        .heading-note-value { 
            font-size: 11px; 
            font-weight: 700; 
            color: #344054; 
        } 
 
        .heading-note-value span { 
            color: var(--green); 
        } 
 
        /* STAT CARDS */ 
 
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(4, minmax(0, 1fr)); 
            gap: 15px; 
            margin-bottom: 20px; 
        } 
 
        .stat-card { 
            background: var(--white); 
            border: 1px solid var(--border); 
            border-radius: 10px; 
            padding: 19px; 
            min-width: 0; 
            box-shadow: 0 1px 2px #10182805; 
        } 
 
        .stat-top { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            gap: 8px; 
        } 
 
        .stat-label { 
            color: #667085; 
            font-size: 10px; 
            font-weight: 700; 
            letter-spacing: .45px; 
            text-transform: uppercase; 
        } 
 
        .stat-icon { 
            width: 34px; 
            height: 34px; 
            display: grid; 
            place-items: center; 
            border-radius: 8px; 
            flex-shrink: 0; 
        } 
 
        .stat-icon svg { 
            width: 18px; 
            height: 18px; 
        } 
 
        .icon-blue { 
            color: #155eef; 
            background: #eaf1ff; 
        } 
 
        .icon-green { 
            color: #079455; 
            background: #dcfae6; 
        } 
 
        .icon-orange { 
            color: #dc6803; 
            background: #fef0c7; 
        } 
 
        .icon-purple { 
            color: #6941c6; 
            background: #f0eaff; 
        } 
 
        .stat-number { 
            font-size: 29px; 
            font-weight: 800; 
            letter-spacing: -1px; 
            line-height: 1.2; 
            margin: 16px 0 12px; 
            color: #101828; 
        } 
 
        .stat-footer { 
            display: flex; 
            align-items: center; 
            gap: 6px; 
            flex-wrap: wrap; 
            color: var(--muted); 
            font-size: 10px; 
        } 
 
        .stat-pill { 
            display: inline-block; 
            padding: 4px 7px; 
            border-radius: 5px; 
            font-size: 9px; 
            font-weight: 700; 
        } 
 
        .pill-green { 
            color: #027a48; 
            background: #d1fadf; 
        } 
 
        .pill-orange { 
            color: #b54708; 
            background: #fef0c7; 
        } 
 
        .pill-blue { 
            color: #1849a9; 
            background: #eaf1ff; 
        } 
 
        /* MAIN GRID */ 
 
        .dashboard-grid { 
            display: grid; 
            grid-template-columns: minmax(0, 1.75fr) minmax(280px, .95fr); 
            gap: 18px; 
            align-items: start; 
        } 
 
        .panel { 
            background: var(--white); 
            border: 1px solid var(--border); 
            border-radius: 10px; 
            overflow: hidden; 
            min-width: 0; 
            box-shadow: 0 1px 2px #10182805; 
        } 
 
        .panel-header { 
            display: flex; 
            align-items: flex-start; 
            justify-content: space-between; 
            gap: 12px; 
            padding: 20px 20px 16px; 
        } 
 
        .panel-title { 
            font-size: 14px; 
            font-weight: 800; 
            letter-spacing: -.2px; 
        } 
 
        .panel-description { 
            margin-top: 6px; 
            color: var(--muted); 
            font-size: 10px; 
            line-height: 1.6; 
        } 
 
        .panel-badge { 
            display: inline-flex; 
            align-items: center; 
            gap: 5px; 
            background: #eff4ff; 
            color: #1849a9; 
            border: 1px solid #dbe6ff; 
            border-radius: 6px; 
            padding: 7px 9px; 
            font-size: 10px; 
            font-weight: 600; 
            white-space: nowrap; 
        } 
 
        .panel-badge svg { 
            width: 13px; 
            height: 13px; 
        } 
 
        /* SECTOR BARS */ 
 
        .sector-list { 
            padding: 4px 20px 20px; 
        } 
 
        .sector-row { 
            padding: 11px 0 12px; 
        } 
 
        .sector-info { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            gap: 12px; 
            margin-bottom: 9px; 
        } 
 
        .sector-name-wrap { 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            min-width: 0; 
        } 
 
        .sector-dot { 
            width: 8px; 
            height: 8px; 
            border-radius: 50%; 
            flex-shrink: 0; 
        } 
 
        .sector-name { 
            font-size: 11px; 
            font-weight: 700; 
            overflow-wrap: anywhere; 
        } 
 
        .sector-count { 
            text-align: right; 
            white-space: nowrap; 
            flex-shrink: 0; 
        } 
 
        .sector-count strong { 
            font-size: 10px; 
            font-weight: 700; 
        } 
 
        .sector-percent { 
            display: inline-block; 
            min-width: 43px; 
            margin-left: 7px; 
            color: var(--muted); 
            font-size: 10px; 
            text-align: right; 
        } 
 
        .progress-track { 
            height: 8px; 
            border-radius: 10px; 
            overflow: hidden; 
            background: #edf1f9; 
        } 
 
        .progress-fill { 
            height: 100%; 
            border-radius: 10px; 
            transition: width .4s ease; 
        } 
 
        /* RECENT DATASETS */ 
 
        .activity-list { 
            padding: 0 15px 12px; 
        } 
 
        .activity-item { 
            display: flex; 
            gap: 11px; 
            padding: 13px 10px; 
            border-bottom: 1px solid #f0f2f5; 
            border-radius: 7px; 
        } 
 
        .activity-item:last-child { 
            border-bottom: 0; 
        } 
 
        .activity-item:hover { 
            background: #f9fafb; 
        } 
 
        .activity-icon { 
            width: 31px; 
            height: 31px; 
            border-radius: 8px; 
            background: #eff4ff; 
            color: var(--primary); 
            display: grid; 
            place-items: center; 
            flex-shrink: 0; 
        } 
 
        .activity-icon svg { 
            width: 16px; 
            height: 16px; 
        } 
 
        .activity-body { 
            min-width: 0; 
            flex: 1; 
        } 
 
        .activity-top { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            gap: 8px; 
            margin-bottom: 6px; 
        } 
 
        .activity-title { 
            font-size: 10px; 
            font-weight: 700; 
        } 
 
        .activity-status { 
            background: #d1fadf; 
            color: #027a48; 
            padding: 3px 6px; 
            border-radius: 4px; 
            font-size: 9px; 
            font-weight: 700; 
            white-space: nowrap; 
        } 
 
        .activity-status.pending { 
            background: #fef0c7; 
            color: #b54708; 
        } 
 
        .activity-name { 
            color: #475467; 
            font-size: 10px; 
            line-height: 1.65; 
            overflow-wrap: anywhere; 
        } 
 
        .activity-meta { 
            display: flex; 
            align-items: center; 
            gap: 5px; 
            color: #98a2b3; 
            font-size: 9px; 
            margin-top: 7px; 
        } 
 
        .activity-meta svg { 
            width: 12px; 
            height: 12px; 
        } 
 
        .panel-footer { 
            padding: 13px 18px; 
            border-top: 1px solid var(--border); 
            background: #fcfcfd; 
        } 
 
        .text-link { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 7px; 
            width: 100%; 
            padding: 10px; 
            border-radius: 7px; 
            background: #eff4ff; 
            color: #1849a9; 
            font-size: 10px; 
            font-weight: 700; 
        } 
 
        .text-link:hover { 
            background: #dbe6ff; 
        } 
 
        .empty-state { 
            padding: 30px 15px; 
            text-align: center; 
            color: var(--muted); 
            font-size: 11px; 
            line-height: 1.7; 
        } 
 
        /* MAPPING SUMMARY */ 
 
        .mapping-panel { 
            margin-top: 18px; 
            padding: 19px 20px; 
        } 
 
        .mapping-top { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            gap: 15px; 
            margin-bottom: 15px; 
        } 
 
        .mapping-title-wrap { 
            display: flex; 
            align-items: center; 
            gap: 11px; 
        } 
 
        .mapping-icon { 
            display: grid; 
            place-items: center; 
            width: 35px; 
            height: 35px; 
            border-radius: 8px; 
            background: #eff4ff; 
            color: var(--primary); 
            flex-shrink: 0; 
        } 
 
        .mapping-icon svg { 
            width: 19px; 
            height: 19px; 
        } 
 
        .mapping-title { 
            font-size: 12px; 
            font-weight: 800; 
        } 
 
        .mapping-subtitle { 
            font-size: 10px; 
            color: var(--muted); 
            margin-top: 5px; 
        } 
 
        .mapping-total { 
            font-size: 11px; 
            font-weight: 700; 
            text-align: right; 
            white-space: nowrap; 
        } 
 
        .mapping-total span { 
            color: var(--green); 
        } 
 
        .mapping-progress { 
            height: 8px; 
            border-radius: 10px; 
            overflow: hidden; 
            background: #fef0c7; 
            display: flex; 
        } 
 
        .mapping-progress-done { 
            background: var(--primary); 
            height: 100%; 
        } 
 
        .mapping-legend { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            gap: 12px; 
            flex-wrap: wrap; 
            margin-top: 12px; 
            color: var(--muted); 
            font-size: 10px; 
        } 
 
        .legend-item { 
            display: flex; 
            align-items: center; 
            gap: 7px; 
        } 
 
        .legend-dot { 
            width: 7px; 
            height: 7px; 
            border-radius: 50%; 
            flex-shrink: 0; 
        } 
 
        /* FOOTER */ 
 
        .footer { 
            display: flex; 
            justify-content: space-between; 
            gap: 15px; 
            padding: 23px 2px 0; 
            color: #98a2b3; 
            font-size: 10px; 
        } 
 
        /* RESPONSIVE */ 
 
        @media (max-width: 1250px) { 
            :root { 
                --sidebar-width: 220px; 
            } 
 
            .content { 
                padding: 22px; 
            } 
 
            .topbar { 
                padding: 0 22px; 
            } 
 
            .stats-grid { 
                gap: 11px; 
            } 
 
            .stat-card { 
                padding: 15px; 
            } 
 
            .dashboard-grid { 
                grid-template-columns: minmax(0, 1.4fr) minmax(270px, 1fr); 
            } 
        } 
 
        @media (max-width: 1000px) { 
            .dashboard-grid { 
                grid-template-columns: 1fr; 
            } 
 
            .stats-grid { 
                grid-template-columns: repeat(2, minmax(0, 1fr)); 
            } 
 
            .search-box { 
                width: 210px; 
            } 
        } 
 
        @media (max-width: 650px) { 
            :root { 
                --sidebar-width: 0px; 
            } 
 
            .sidebar { 
                position: static; 
                width: 100%; 
                border-right: 0; 
                border-bottom: 1px solid var(--border); 
            } 
 
            .brand { 
                height: 65px; 
            } 
 
            .nav-label { 
                padding: 14px 16px 8px; 
            } 
 
            .nav-menu { 
                padding: 0 12px 12px; 
                display: grid; 
                grid-template-columns: repeat(2, minmax(0, 1fr)); 
            } 
 
            .nav-link { 
                min-height: 38px; 
                padding: 0 10px; 
                font-size: 11px; 
            } 
 
            .sidebar-bottom { 
                display: none; 
            } 
 
            .main { 
                margin-left: 0; 
            } 
 
            .topbar { 
                height: auto; 
                min-height: 58px; 
                padding: 12px 16px; 
            } 
 
            .breadcrumb { 
                font-size: 10px; 
            } 
 
            .topbar-right { 
                display: none; 
            } 
 
            .content { 
                padding: 15px; 
            } 
 
            .page-heading { 
                padding: 17px; 
            } 
 
            .page-heading h1 { 
                font-size: 20px; 
            } 
 
            .heading-note { 
                display: none; 
            } 
 
            .stats-grid { 
                gap: 10px; 
            } 
 
            .stat-card { 
                padding: 14px; 
            } 
 
            .stat-number { 
                font-size: 25px; 
            } 
 
            .stat-label { 
                font-size: 9px; 
            } 
 
            .stat-icon { 
                width: 29px; 
                height: 29px; 
            } 
 
            .panel-header { 
                padding: 16px; 
            } 
 
            .sector-list { 
                padding: 0 15px 15px; 
            } 
 
            .sector-name { 
                font-size: 10px; 
            } 
 
            .sector-percent { 
                display: none; 
            } 
 
            .mapping-top { 
                align-items: flex-start; 
            } 
 
            .mapping-total { 
                font-size: 10px; 
            } 
 
            .footer { 
                flex-direction: column; 
            } 
        } 


        /* PENYESUAIAN VISUAL PORTAL PEMERINTAH */
        :root {
            --primary: #174a6e;
            --primary-dark: #103750;
            --primary-light: #eaf2f7;
            --bg: #f3f6f8;
            --text: #1d2939;
            --muted: #667085;
            --border: #dfe6eb;
            --green: #16794b;
            --orange: #a85b08;
        }

        body {
            background: #f3f6f8;
            color: #1d2939;
            font-size: 13px;
            line-height: 1.5;
        }

        .sidebar {
            background: #fff;
            border-right-color: #d9e2e8;
            box-shadow: 2px 0 12px rgba(16, 55, 80, .025);
        }

        .brand {
            min-height: 82px;
            height: auto;
            padding-top: 13px;
            padding-bottom: 13px;
            border-bottom-color: #e5ebef;
        }

        .brand-icon {
            background: #174a6e;
            border-radius: 8px;
        }

        .brand-title {
            color: #123b57;
            font-size: 14px;
            letter-spacing: -.2px;
        }

        .brand-subtitle {
            color: #526b7b;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .45px;
            line-height: 1.5;
        }

        .nav-label {
            color: #738493;
            letter-spacing: .7px;
        }

        .nav-link {
            border: 1px solid transparent;
            border-radius: 7px;
            min-height: 43px;
        }

        .nav-link:hover {
            color: #174a6e;
            background: #f0f5f8;
        }

        .nav-link.active {
            background: #eaf2f7;
            border-color: #d5e5ef;
            color: #123f5d;
            box-shadow: inset 3px 0 0 #174a6e;
        }

        .nav-link.active .nav-tag {
            color: #174a6e;
            background: #fff;
        }

        .version-card {
            background: #f6f9fb;
            border-color: #e0e8ed;
            border-radius: 8px;
        }

        .version-dot { background: #647d8d; }

        .topbar {
            background: rgba(255,255,255,.97);
            border-bottom-color: #dfe6eb;
            min-height: 68px;
        }

        .breadcrumb strong { color: #174a6e; }

        .search-box {
            background: #f8fafb;
            border-color: #dbe4e9;
            border-radius: 7px;
        }

        .search-box:focus-within {
            border-color: #7b9fb5;
            box-shadow: 0 0 0 3px rgba(23,74,110,.08);
        }

        .content { padding-top: 28px; }

        .page-heading {
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .eyebrow {
            color: #47697f;
            font-size: 10px;
            letter-spacing: .75px;
            text-transform: uppercase;
        }

        .eyebrow-dot { background: #16794b; }

        .page-heading h1 {
            color: #163e59;
            font-size: clamp(22px, 2vw, 27px);
            letter-spacing: -.7px;
            line-height: 1.3;
        }

        .page-heading p {
            max-width: 680px;
            color: #5c6d79;
            line-height: 1.7;
        }

        .heading-note {
            background: #fff;
            border: 1px solid #dfe7ec;
            border-radius: 8px;
            box-shadow: none;
        }

        .heading-note-value { color: #174a6e; }

        .stat-card, .panel {
            border: 1px solid #dfe6eb;
            border-radius: 9px;
            box-shadow: 0 2px 8px rgba(16,55,80,.025);
        }

        .stat-card:hover, .panel:hover {
            box-shadow: 0 5px 16px rgba(16,55,80,.055);
        }

        .stat-label { color: #5e6f7b; }
        .stat-number { color: #163e59; }
        .icon-blue { background: #eaf2f7; color: #174a6e; }
        .icon-green { background: #eaf6ef; color: #16794b; }
        .icon-orange { background: #fff3e5; color: #a85b08; }
        .icon-purple { background: #f1edfa; color: #6950a1; }

        .panel-title, .mapping-title { color: #163e59; }
        .panel-subtitle, .mapping-subtitle { color: #667784; }
        .text-link { color: #174a6e; }
        .text-link:hover { color: #103750; }

        .mapping-progress { background: #e8edf0; }
        .mapping-progress-done { background: #174a6e; }
        .mapping-icon { background: #eaf2f7; color: #174a6e; }
        .footer { color: #74838d; border-top-color: #dfe6eb; }

        .search-empty-state[hidden] { display: none !important; }

        @media print {
            body { background: #fff !important; color: #111827 !important; }
            .sidebar, .topbar, .search-box, .panel-footer, .heading-note { display: none !important; }
            .main { margin-left: 0 !important; min-height: 0 !important; }
            .content { max-width: none !important; padding: 0 !important; }
            .page-heading, .stat-card, .panel {
                box-shadow: none !important;
                border-color: #cbd5e1 !important;
                break-inside: avoid;
            }
            .stats-grid { grid-template-columns: repeat(4, minmax(0, 1fr)) !important; }
            .dashboard-grid { grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr) !important; }
            .footer { margin-top: 18px !important; color: #475569 !important; }
            a { text-decoration: none !important; }
        }


        button:focus-visible, a:focus-visible, input:focus-visible {
            outline: 3px solid rgba(23,74,110,.25);
            outline-offset: 2px;
        }

        @media (max-width: 900px) {
            .topbar { padding-left: 20px; padding-right: 20px; }
            .content { padding-left: 20px; padding-right: 20px; }
        }

        @media (max-width: 640px) {
            .topbar { min-height: auto; height: auto; padding: 14px 16px; align-items: flex-start; }
            .topbar-right { gap: 8px; }
            .search-box { width: min(48vw, 220px); }
            .content { padding: 22px 15px; }
            .page-heading { gap: 14px; }
            .heading-note { min-width: 0; }
            .brand { padding-left: 15px; }
        }

    
        /* Search bar: satu bingkai luar, input tanpa bingkai bertumpuk */
        .search-box {
            display: flex;
            align-items: center;
            gap: 9px;
            width: min(430px, 42vw);
            min-width: 230px;
            height: 42px;
            padding: 0 8px 0 12px;
            background: #fff;
            border: 1px solid #d0d5dd;
            border-radius: 10px;
            box-shadow: none;
        }
        .search-box:focus-within {
            border-color: #84adff;
            box-shadow: 0 0 0 3px rgba(21, 94, 239, .10);
            outline: none;
        }
        .search-box input,
        .search-box input:focus,
        .search-box input:focus-visible {
            flex: 1;
            width: 100%;
            min-width: 0;
            height: 100%;
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
            background: transparent;
            font: inherit;
            font-size: 12px;
        }
        .search-clear {
            color: #667085;
            font-size: 21px;
            line-height: 1;
            text-decoration: none;
            padding: 0 2px;
        }
        .search-submit {
            border: 0;
            border-radius: 7px;
            background: #155eef;
            color: #fff;
            padding: 7px 10px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }
        .search-submit:hover { background: #1249bd; }
        .search-results-panel {
            margin: 18px 30px 0;
            padding: 18px;
            border: 1px solid #e4e7ec;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(16, 24, 40, .04);
        }
        .search-results-heading { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:14px; }
        .search-results-heading h2 { font-size:15px; margin:0 0 5px; }
        .search-results-heading p { color:#667085; font-size:12px; margin:0; }
        .search-view-all { color:#155eef; font-size:12px; font-weight:600; white-space:nowrap; }
        .search-results-list { display:flex; flex-direction:column; }
        .search-result-item { display:flex; align-items:center; gap:12px; padding:12px 4px; border-top:1px solid #f0f2f5; text-decoration:none; color:inherit; }
        .search-result-item:hover { background:#f8faff; }
        .search-result-icon { display:grid; place-items:center; width:34px; height:34px; border-radius:8px; background:#eff4ff; color:#155eef; flex-shrink:0; font-size:18px; }
        .search-result-main { display:flex; flex-direction:column; gap:4px; min-width:0; flex:1; }
        .search-result-main strong { font-size:12px; line-height:1.5; }
        .search-result-main small { color:#667085; font-size:11px; }
        .search-result-sector { color:#475467; background:#f2f4f7; border-radius:6px; padding:5px 8px; font-size:10px; white-space:nowrap; }
        .search-no-results { display:flex; flex-direction:column; gap:6px; border-radius:8px; padding:16px; background:#f9fafb; color:#475467; font-size:12px; }
        .search-no-results strong { color:#344054; }
        .search-limit-note { margin-top:10px; color:#667085; font-size:11px; }
        @media (max-width: 700px) {
            .search-box { width: min(58vw, 330px); min-width: 0; }
            .search-submit { padding:7px; }
            .search-results-panel { margin:12px 14px 0; padding:14px; }
            .search-results-heading { align-items:flex-start; flex-direction:column; }
            .search-result-sector { display:none; }
        }

        /* FIX: kotak sumber data tidak boleh memotong teks */
        .page-heading {
            min-width: 0;
            flex-wrap: wrap;
        }

        .page-heading > div:first-child {
            flex: 1 1 320px;
            min-width: 0;
        }

        .heading-note {
            flex: 0 1 300px;
            width: 100%;
            min-width: 0;
            max-width: 100%;
            padding: 14px 16px;
            text-align: left;
            overflow-wrap: anywhere;
            white-space: normal;
        }

        .heading-note-label,
        .heading-note-value,
        .heading-note-value span {
            display: block;
            max-width: 100%;
            white-space: normal;
            overflow-wrap: anywhere;
            word-break: normal;
        }

        .heading-note-label {
            line-height: 1.5;
        }

        .heading-note-value {
            line-height: 1.6;
        }

        @media (max-width: 640px) {
            .page-heading {
                align-items: stretch;
            }

            .heading-note {
                flex: 1 1 100%;
                width: 100%;
            }
        }


        /* Final override: keep the source-data card and its text inside the card. */
        .page-heading {
            display: flex !important;
            align-items: stretch !important;
            flex-wrap: wrap !important;
            min-width: 0 !important;
            overflow: visible !important;
        }
        .page-heading > div:first-child {
            flex: 1 1 320px !important;
            min-width: 0 !important;
        }
        .page-heading .heading-note {
            box-sizing: border-box !important;
            flex: 0 1 280px !important;
            width: 280px !important;
            min-width: 220px !important;
            max-width: 100% !important;
            height: auto !important;
            padding: 14px 16px !important;
            margin: 0 !important;
            text-align: left !important;
            white-space: normal !important;
            overflow: visible !important;
            overflow-wrap: break-word !important;
            word-break: normal !important;
        }
        .page-heading .heading-note * {
            box-sizing: border-box !important;
            max-width: 100% !important;
            white-space: normal !important;
            text-align: left !important;
            overflow: visible !important;
            text-overflow: clip !important;
            overflow-wrap: anywhere !important;
            word-break: normal !important;
        }
        .page-heading .heading-note-label,
        .page-heading .heading-note-value,
        .page-heading .heading-note-value span {
            display: block !important;
            width: 100% !important;
            line-height: 1.6 !important;
        }
        @media (max-width: 700px) {
            .page-heading .heading-note {
                flex: 1 1 100% !important;
                width: 100% !important;
                min-width: 0 !important;
            }
        }


        /* TOMBOL LOGOUT */
        .logout-form {
            display: flex;
            flex: 0 0 auto;
            margin: 0;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 10px 17px;
            border: 0;
            border-radius: 999px;
            background: #174a6e;
            color: #fff;
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 3px 9px rgba(23, 74, 110, .16);
        }

        .logout-btn svg {
            width: 16px;
            height: 16px;
        }

        .logout-btn:hover {
            background: #103750;
            transform: translateY(-1px);
            box-shadow: 0 5px 12px rgba(23, 74, 110, .22);
        }

        @media (max-width: 1000px) {
            .topbar-right { gap: 10px; }
            .profile { display: none; }
        }

        @media (max-width: 650px) {
            .topbar {
                align-items: stretch;
                flex-direction: column;
                gap: 12px;
            }
            .topbar-right {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                width: 100%;
            }
            .search-box {
                flex: 1 1 190px;
                width: auto;
                min-width: 0;
            }
            .logout-form { flex: 0 0 auto; }
            .logout-btn { min-height: 40px; padding: 9px 14px; }
        }

        @media print {
            .logout-form { display: none !important; }
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
 
 
    <aside class="sidebar"> 
 
        <a href="{{ url('/dashboard') }}" class="brand"> 
 
            <div class="brand-icon"> 
 
                <svg viewBox="0 0 24 24" fill="none" 
                     stroke="currentColor" stroke-width="1.8" 
                     stroke-linecap="round" stroke-linejoin="round"> 
 
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
                    PEMERINTAH KOTA SURAKARTA 
                </div> 
 
            </div> 
 
        </a> 
 
 
        <div class="nav-label"> 
            NAVIGASI UTAMA 
        </div> 
 
 
        <nav class="nav-menu"> 
 
            {{-- DASHBOARD --}} 
 
            <a 
                href="{{ url('/dashboard') }}" 
                class="nav-link {{ request()->is('dashboard') || request()->is('/') ? 'active' : '' }}" 
            > 
 
                <svg viewBox="0 0 24 24" fill="none" 
                     stroke="currentColor" stroke-width="1.8" 
                     stroke-linecap="round" stroke-linejoin="round"> 
 
                    <rect x="3" y="3" width="8" height="8" rx="1.5"/> 
                    <rect x="14" y="3" width="7" height="5" rx="1.5"/> 
                    <rect x="14" y="11" width="7" height="10" rx="1.5"/> 
                    <rect x="3" y="14" width="8" height="7" rx="1.5"/> 
 
                </svg> 
 
                <span> 
                    Dashboard 
                </span> 
 
            </a> 
 
 
            {{-- DATASET --}} 
 
            <a 
                href="{{ url('/dataset') }}" 
                class="nav-link {{ request()->is('dataset') ? 'active' : '' }}" 
            > 
 
                <svg viewBox="0 0 24 24" fill="none" 
                     stroke="currentColor" stroke-width="1.8" 
                     stroke-linecap="round" stroke-linejoin="round"> 
 
                    <ellipse cx="12" cy="5" rx="8" ry="3"/> 
                    <path d="M4 5v14c0 1.7 3.6 3 8 3s8-1.3 8-3V5"/> 
                    <path d="M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3"/> 
 
                </svg> 
 
                <span> 
                    Dataset 
                </span> 
 
            </a> 
 
 
            {{-- PEMETAAN DATA --}} 
 
            <a 
                href="{{ url('/pemetaan') }}" 
                class="nav-link {{ request()->is('pemetaan') ? 'active' : '' }}" 
            > 
 
                <svg viewBox="0 0 24 24" fill="none" 
                     stroke="currentColor" stroke-width="1.8" 
                     stroke-linecap="round" stroke-linejoin="round"> 
 
                    <rect x="3" y="3" width="7" height="6" rx="1.5"/> 
                    <rect x="14" y="15" width="7" height="6" rx="1.5"/> 
                    <rect x="3" y="15" width="7" height="6" rx="1.5"/> 
                    <path d="M6.5 9v3h11v3M17.5 12h-11"/> 
 
                </svg> 
 
                <span> 
                    Pemetaan Data 
                </span> 
 
            </a> 
 
 
            {{-- KLASIFIKASI --}} 
 
            <a 
                href="{{ url('/dataset/belum-terklasifikasi') }}" 
                class="nav-link {{ request()->is('dataset/belum-terklasifikasi') ? 'active' : '' }}" 
            > 
 
                <svg viewBox="0 0 24 24" fill="none" 
                     stroke="currentColor" stroke-width="1.8" 
                     stroke-linecap="round" stroke-linejoin="round"> 
 
                    <path d="m9 12 2 2 4-4"/> 
                    <circle cx="12" cy="12" r="9"/> 
                    <path d="M12 3v2M21 12h-2M12 21v-2M3 12h2"/> 
 
                </svg> 
 
                <span> 
                    Klasifikasi 
                </span> 
 
            </a> 
 
 
            {{-- ANALISIS DATA --}} 
 
            <a 
                href="{{ url('/analisis') }}" 
                class="nav-link {{ request()->is('analisis') ? 'active' : '' }}" 
            > 
 
                <svg viewBox="0 0 24 24" fill="none" 
                     stroke="currentColor" stroke-width="1.8" 
                     stroke-linecap="round" stroke-linejoin="round"> 
 
                    <path d="M3 3v18h18"/> 
                    <path d="m7 14 4-4 4 3 5-7"/> 
 
                </svg> 
 
                <span> 
                    Analisis Data 
                </span> 
 
            </a> 
 
        </nav> 
 
 
        <div class="sidebar-bottom"> 
 
            <div class="version-card"> 
 
                <div class="version-title"> 
 
                    <span class="version-dot"></span> 
 
                    LINGKUNGAN APLIKASI 
 
                </div> 
 
                <div class="version-desc"> 
 
                    Prototipe untuk membantu pengelolaan, klasifikasi, dan pemetaan dataset OPD. 
 
                </div> 
 
            </div> 
 
        </div> 
 
    </aside> 
 
 
    <main class="main"> 
 
        <header class="topbar"> 
 
            <div class="breadcrumb"> 
 
                <span> 
                    Satu Data OPD 
                </span> 
 
                <span class="breadcrumb-arrow"> 
                    › 
                </span> 
 
                <strong> 
                    Dashboard 
                </strong> 
 
            </div> 
 
 
            <div class="topbar-right"> 
 
                <form class="search-box" method="GET" action="{{ url('/dashboard') }}" role="search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m16 16 4 4"/>
                    </svg>
                    <input type="search" id="dashboardSearch" name="search"
                           value="{{ $searchQuery ?? '' }}"
                           placeholder="Cari dataset, OPD, atau sektor..."
                           aria-label="Cari seluruh dataset, OPD, atau sektor">
                    @if (!empty($searchQuery))
                        <a class="search-clear" href="{{ url('/dashboard') }}" aria-label="Hapus pencarian" title="Hapus pencarian">×</a>
                    @endif
                    <button class="search-submit" type="submit">Cari</button>
                </form> 
 
 
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

                <form class="logout-form" method="POST" action="{{ route('logout') }}"
                      onsubmit="return confirm('Apakah kamu yakin ingin keluar dari sistem?')">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M10 17l5-5-5-5"/>
                            <path d="M15 12H3"/>
                            <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                        </svg>
                        Logout
                    </button>
                </form> 
 
            </div> 
 
        </header> 
 
 
        @if (!empty($searchQuery))
            <section class="search-results-panel" aria-live="polite">
                <div class="search-results-heading">
                    <div>
                        <h2>Hasil pencarian</h2>
                        <p>Kata kunci: <strong>{{ $searchQuery }}</strong> · {{ $jumlahHasilPencarian }} hasil ditemukan</p>
                    </div>
                    <a href="{{ url('/dataset') }}" class="search-view-all">Buka katalog dataset →</a>
                </div>
                @if ($hasilPencarian->isEmpty())
                    <div class="search-no-results">
                        <strong>Tidak ada dataset yang cocok.</strong>
                        <span>Coba kata kunci lain, misalnya nama OPD, nama data, atau sektor.</span>
                    </div>
                @else
                    <div class="search-results-list">
                        @foreach ($hasilPencarian as $hasil)
                            <a class="search-result-item" href="{{ url('/dataset') }}">
                                <span class="search-result-icon" aria-hidden="true">▤</span>
                                <span class="search-result-main">
                                    <strong>{{ $hasil->nama_statistik ?: ($hasil->nama_data_sektoral ?: 'Dataset tanpa nama') }}</strong>
                                    <small>{{ $hasil->opd->nama_opd ?? 'OPD belum diisi' }}</small>
                                </span>
                                <span class="search-result-sector">{{ $hasil->sektor->nama_sektor ?? 'Belum dipetakan' }}</span>
                            </a>
                        @endforeach
                    </div>
                    @if ($jumlahHasilPencarian > $hasilPencarian->count())
                        <p class="search-limit-note">Menampilkan {{ $hasilPencarian->count() }} dari {{ $jumlahHasilPencarian }} hasil. Buka katalog untuk melihat data lainnya.</p>
                    @endif
                @endif
            </section>
        @endif

        <div class="content"> 
 
            <!-- PAGE HEADING --> 
 
            <section class="page-heading"> 
 
                <div> 
 
                    <div class="eyebrow"> 
 
                        <span class="eyebrow-dot"></span> 
 
                        Tata Kelola Satu Data 
 
                    </div> 
 
 
                    <h1> 
                        Dashboard Ikhtisar Dataset OPD 
                    </h1> 
 
 
                    <p> 
                        Ringkasan statistik pengelolaan, klasifikasi, dan 
                        pemetaan dataset Organisasi Perangkat Daerah. 
                    </p> 
 
                </div> 
 
 
                <div class="heading-note"> 
 
                    <div class="heading-note-label"> 
                        SUMBER DATA 
                    </div> 
 
                    <div class="heading-note-value"> 
                        <span>Database aplikasi</span> 
                    </div> 
 
                    <div 
                        class="heading-note-label" 
                        style="margin-top:7px" 
                    > 
                        Statistik mengikuti data tersimpan 
                    </div> 
 
                </div> 
 
            </section> 
 
 
            <!-- KPI CARDS --> 
 
            <section class="stats-grid"> 
 
                <article class="stat-card"> 
 
                    <div class="stat-top"> 
 
                        <div class="stat-label"> 
                            Total Dataset 
                        </div> 
 
                        <div class="stat-icon icon-blue"> 
 
                            <svg viewBox="0 0 24 24" fill="none" 
                                 stroke="currentColor" stroke-width="1.8" 
                                 stroke-linecap="round" 
                                 stroke-linejoin="round"> 
 
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/> 
                                <path d="M14 2v6h6M8 13h8M8 17h8"/> 
 
                            </svg> 
 
                        </div> 
 
                    </div> 
 
 
                    <div class="stat-number"> 
 
                        {{ number_format($totalDataset, 0, ',', '.') }} 
 
                    </div> 
 
 
                    <div class="stat-footer"> 
 
                        Seluruh dataset terdaftar 
 
                    </div> 
 
                </article> 
 
 
                <article class="stat-card"> 
 
                    <div class="stat-top"> 
 
                        <div class="stat-label"> 
                            Terklasifikasi 
                        </div> 
 
                        <div class="stat-icon icon-green"> 
 
                            <svg viewBox="0 0 24 24" fill="none" 
                                 stroke="currentColor" stroke-width="1.8" 
                                 stroke-linecap="round" 
                                 stroke-linejoin="round"> 
 
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
 
                            {{ $totalDataset > 0 ? round(($totalTerklasifikasi / $totalDataset) * 100, 1) : 0 }}% 
 
                        </span> 
 
                        Dataset berstatus terklasifikasi 
 
                    </div> 
 
                </article> 
 
 
                <article class="stat-card"> 
 
                    <div class="stat-top"> 
 
                        <div class="stat-label"> 
                            Belum Diklasifikasi 
                        </div> 
 
                        <div class="stat-icon icon-orange"> 
 
                            <svg viewBox="0 0 24 24" fill="none" 
                                 stroke="currentColor" stroke-width="1.8" 
                                 stroke-linecap="round" 
                                 stroke-linejoin="round"> 
 
                                <circle cx="12" cy="12" r="9"/> 
                                <path d="M12 8v5M12 16.5h.01"/> 
 
                            </svg> 
 
                        </div> 
 
                    </div> 
 
 
                    <div class="stat-number"> 
 
                        {{ number_format($totalBelumTerklasifikasi, 0, ',', '.') }} 
 
                    </div> 
 
 
                    <div class="stat-footer"> 
 
                        <span class="stat-pill pill-orange"> 
                            Perlu ditinjau 
                        </span> 
 
                    </div> 
 
                </article> 
 
 
                <article class="stat-card"> 
 
                    <div class="stat-top"> 
 
                        <div class="stat-label"> 
                            Jumlah Sektor 
                        </div> 
 
                        <div class="stat-icon icon-purple"> 
 
                            <svg viewBox="0 0 24 24" fill="none" 
                                 stroke="currentColor" stroke-width="1.8" 
                                 stroke-linecap="round" 
                                 stroke-linejoin="round"> 
 
                                <rect x="3" y="3" width="7" height="7" rx="1.5"/> 
                                <rect x="14" y="3" width="7" height="7" rx="1.5"/> 
                                <rect x="3" y="14" width="7" height="7" rx="1.5"/> 
                                <rect x="14" y="14" width="7" height="7" rx="1.5"/> 
 
                            </svg> 
 
                        </div> 
 
                    </div> 
 
 
                    <div class="stat-number"> 
 
                        {{ number_format($totalSektor, 0, ',', '.') }} 
 
                    </div> 
 
 
                    <div class="stat-footer"> 
 
                        <span class="stat-pill pill-blue"> 
                            Kategori sektor 
                        </span> 
 
                    </div> 
 
                </article> 
 
            </section> 
 
 
            <!-- DISTRIBUSI SEKTOR + DATA TERBARU --> 
 
            <section class="dashboard-grid"> 
 
                <!-- SECTOR DISTRIBUTION --> 
 
                <article class="panel"> 
 
                    <div class="panel-header"> 
 
                        <div> 
 
                            <h2 class="panel-title"> 
                                Distribusi Dataset Berdasarkan Sektor 
                            </h2> 
 
                            <p class="panel-description"> 
                                Sebaran dataset menurut sektor hasil klasifikasi. 
                            </p> 
 
                        </div> 
 
 
                        <div class="panel-badge"> 
 
                            <svg viewBox="0 0 24 24" fill="none" 
                                 stroke="currentColor" stroke-width="1.8" 
                                 stroke-linecap="round" 
                                 stroke-linejoin="round"> 
 
                                <rect x="3" y="3" width="18" height="18" rx="3"/> 
                                <path d="M8 16V11M12 16V7M16 16v-3"/> 
 
                            </svg> 
 
                            {{ $totalSektor }} Sektor 
 
                        </div> 
 
                    </div> 
 
 
                    <div class="sector-list"> 
 
                        @forelse ($distribusiSektor as $sektor) 
 
                            @php 
 
                                $warna = $sectorColors[ 
                                    $loop->index % count($sectorColors) 
                                ]; 
 
                                $lebarBar = $maksDatasetSektor > 0 
                                    ? ($sektor->datasets_count / $maksDatasetSektor) * 100 
                                    : 0; 
 
                                $persentase = $totalDataset > 0 
                                    ? round( 
                                        ($sektor->datasets_count / $totalDataset) * 100, 
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
 
                                            {{ number_format( 
                                                $sektor->datasets_count, 
                                                0, 
                                                ',', 
                                                '.' 
                                            ) }} 
 
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
 
 
                <!-- LATEST DATASETS --> 
 
                <article class="panel"> 
 
                    <div class="panel-header"> 
 
                        <div> 
 
                            <h2 class="panel-title"> 
                                Dataset Terbaru 
                            </h2> 
 
                            <p class="panel-description"> 
                                Dataset terakhir yang masuk ke sistem. 
                            </p> 
 
                        </div> 
 
 
                        <div class="panel-badge"> 
                            Terbaru 
                        </div> 
 
                    </div> 
 
 
                    <div class="activity-list"> 
 
                        @forelse ($datasetTerbaru as $dataset) 
 
                            <div class="activity-item"> 
 
                                <div class="activity-icon"> 
 
                                    <svg viewBox="0 0 24 24" fill="none" 
                                         stroke="currentColor" stroke-width="1.8" 
                                         stroke-linecap="round" 
                                         stroke-linejoin="round"> 
 
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/> 
                                        <path d="M14 2v6h6M8 13h8M8 17h5"/> 
 
                                    </svg> 
 
                                </div> 
 
 
                                <div class="activity-body"> 
 
                                    <div class="activity-top"> 
 
                                        <span class="activity-title"> 
                                            Dataset terdaftar 
                                        </span> 
 
 
                                        @if (($dataset->status_pemetaan ?? 'belum') === 'terpetakan') 
 
                                            <span class="activity-status"> 
                                                Terpetakan 
                                            </span> 
 
                                        @else 
 
                                            <span class="activity-status pending"> 
                                                Belum dipetakan 
                                            </span> 
 
                                        @endif 
 
                                    </div> 
 
 
                                    <div class="activity-name"> 
 
                                        {{ $dataset->nama_statistik 
                                            ?: ($dataset->nama_data_sektoral 
                                                ?: 'Dataset tanpa nama') }} 
 
                                    </div> 
 
 
                                    <div class="activity-meta"> 
 
                                        <svg viewBox="0 0 24 24" fill="none" 
                                             stroke="currentColor" 
                                             stroke-width="1.8" 
                                             stroke-linecap="round" 
                                             stroke-linejoin="round"> 
 
                                            <rect 
                                                x="3" 
                                                y="4" 
                                                width="18" 
                                                height="17" 
                                                rx="2" 
                                            /> 
 
                                            <path d="M16 2v4M8 2v4M3 10h18"/> 
 
                                        </svg> 
 
 
                                        {{ $dataset->opd->nama_opd 
                                            ?? 'OPD belum tersedia' }} 
 
                                    </div> 
 
 
                                    @if ($dataset->sektor) 
 
                                        <div class="activity-meta"> 
 
                                            Sektor: 
                                            {{ $dataset->sektor->nama_sektor }} 
 
                                        </div> 
 
                                    @endif 
 
                                </div> 
 
                            </div> 
 
                        @empty 
 
                            <div class="empty-state"> 
                                Belum ada dataset yang dapat ditampilkan. 
                            </div> 
 
                        @endforelse


 
                    </div> 
 
 
                    <div class="panel-footer"> 
 
                        <a 
                            href="{{ url('/dataset') }}" 
                            class="text-link" 
                        > 
                            Lihat Katalog Dataset 
                            <span>→</span> 
                        </a> 
 
                    </div> 
 
                </article> 
 
            </section> 
 
 
            <!-- MAPPING SUMMARY --> 
 
            <section class="panel mapping-panel"> 
 
                <div class="mapping-top"> 
 
                    <div class="mapping-title-wrap"> 
 
                        <div class="mapping-icon"> 
 
                            <svg viewBox="0 0 24 24" fill="none" 
                                 stroke="currentColor" 
                                 stroke-width="1.8" 
                                 stroke-linecap="round" 
                                 stroke-linejoin="round"> 
 
                                <path d="M3 7h7l2 3h9v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/> 
                                <path d="M3 7V5a2 2 0 0 1 2-2h5l2 3h7a2 2 0 0 1 2 2v2"/> 
 
                            </svg> 
 
                        </div> 
 
 
                        <div> 
 
                            <h2 class="mapping-title"> 
                                Ringkasan Pemetaan Dataset 
                            </h2> 
 
                            <p class="mapping-subtitle"> 
                                Status dataset berdasarkan sektor yang terhubung. 
                            </p> 
 
                        </div> 
 
                    </div> 
 
 
                    <div class="mapping-total"> 
 
                        <span> 
                            {{ $persentaseTerpetakan }}% Terpetakan 
                        </span> 
 
                        <div style="margin-top:5px; color:#667085; font-weight:500"> 
 
                            {{ number_format( 
                                $totalTerpetakan, 
                                0, 
                                ',', 
                                '.' 
                            ) }} 
 
                            / 
 
                            {{ number_format( 
                                $totalDataset, 
                                0, 
                                ',', 
                                '.' 
                            ) }} 
 
                            dataset 
 
                        </div> 
 
                    </div> 
 
                </div> 
 
 
                <div class="mapping-progress"> 
 
                    <div 
                        class="mapping-progress-done" 
                        style="width: {{ min(100, max(0, (float) $persentaseTerpetakan)) }}%" 
                    ></div> 
 
                </div> 
 
 
                <div class="mapping-legend"> 
 
                    <div class="legend-item"> 
 
                        <span 
                            class="legend-dot" 
                            style="background:#155eef" 
                        ></span> 
 
                        {{ number_format( 
                            $totalTerpetakan, 
                            0, 
                            ',', 
                            '.' 
                        ) }} 
 
                        dataset sudah terpetakan 
 
                    </div> 
 
 
                    <div class="legend-item"> 
 
                        <span 
                            class="legend-dot" 
                            style="background:#f79009" 
                        ></span> 
 
                        {{ number_format( 
                            $totalBelumTerpetakan, 
                            0, 
                            ',', 
                            '.' 
                        ) }} 
 
                        dataset belum terpetakan 
 
                    </div> 
 
 
                    <a 
                        href="{{ url('/pemetaan') }}" 
                        style="color:#1849a9; font-weight:700" 
                    > 
                        Buka Pemetaan Data → 
                    </a> 
 
                </div> 
 
            </section> 
 
 
            <footer class="footer"> 
 
                <span> 
                    Satu Data OPD · Portal Pemetaan Dataset 
                </span> 
 
                <span> 
                    Portal internal · {{ date('Y') }} 
                </span> 
 
            </footer> 
 
        </div> 
 
    </main> 
 
 
    <script>
        // Pencarian dikirim ke server agar mencakup seluruh dataset, OPD, dan sektor.
        const dashboardSearch = document.getElementById('dashboardSearch');
        if (dashboardSearch) {
            dashboardSearch.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    this.value = '';
                    window.location.href = "{{ url('/dashboard') }}";
                }
            });
        }
    </script> 
 
</body> 
</html>