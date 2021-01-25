/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  Strucutre:
          url     => router path
          name    => name to display in sidebar
          slug    => router path name
          icon    => Feather Icon component/icon name
          tag     => text to display on badge
          tagColor  => class to apply on badge element
          i18n    => Internationalization
          submenu   => submenu of current item (current item will become dropdown )
                NOTE: Submenu don't have any icon(you can add icon if u want to display)
          isDisabled  => disable sidebar item/group
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default [
  {
    url: "/information",
    name: "정보관리", //company-info
    slug: "정보관리", 
    showSubmenuOn: '/information',
    submenu: [
      {
        url: "/information/company",
        name: "회사정보등록",
        slug: "회사정보등록",
        showSubmenuOn: '/information',
      },
      {
        url: "/information/user",
        name: "HACCP담당자 관리",
        slug: "HACCP담당자 관리",
        showSubmenuOn: '/information',
      },
      {
        url: "/information/worker",
        name: "생산담당자 관리",
        slug: "생산담당자 관리",
        showSubmenuOn: '/information',
      },
      {
        url: "/information/haccp",
        name: "HACCP서류등록",
        slug: "HACCP서류등록",
        showSubmenuOn: '/information',
        submenu: [
          {
            url: "/information/haccp/standard-doc",
            name: "HACCP 기준서 등록",
            slug: "HACCP 기준서 등록",
            showSubmenuOn: '/information',
          },
          {
            url: "/information/haccp/food-doc",
            name: "식품위생서류 등록",
            slug: "식품위생서류 등록",
            showSubmenuOn: '/information',
          },
          {
            url: "/information/haccp/haccp-doc",
            name: "HACCP 이행점검표",
            slug: "HACCP 이행점검표",
            showSubmenuOn: '/information',
          }
        ]
      },
      {
        url: "/information/material",
        name: "원/부자재 관리",
        slug: "원/부자재 관리",
        showSubmenuOn: '/information',
      },
      {
        url: "/information/material-unit",
        name: "원/부자재 단위관리",
        slug: "원/부자재 단위관리",
        showSubmenuOn: '/information',
      },
      {
        url: "/information/bom",
        name: "BOM 관리",
        slug: "BOM 관리",
        showSubmenuOn: '/information',
      },
      {
        url: "/information/security",
        name: "정보보호관리",
        slug: "정보보호관리",
        showSubmenuOn: '/information',
      },
      {
        url: "/information/app-version",
        name: "App Version",
        slug: "App Version",
        showSubmenuOn: '/information',
      },
    ]
  },
  {
    url: "/product",
    name: "생산관리",
    slug: "생산관리",
    showSubmenuOn: '/product',
    submenu: [
      {
        url: "/product/standard",
        name: "제품별 표준공정등록",
        slug: "제품별 표준공정등록",
        showSubmenuOn: '/product',
      },
      {
        url: "/product/job-order",
        name: "생산지시 등록",
        slug: "생산지시 등록",
        showSubmenuOn: '/product',
      },
      {
        url: "/product/job-order-query",
        name: "생산지시 조회",
        slug: "생산지시 조회",
        showSubmenuOn: '/product',
      },
      {
        url: "/product/job-order-worker",
        name: "작업자 배치",
        slug: "작업자 배치",
        showSubmenuOn: '/product',
      },
      {
        url: "/product/5",
        name: "생산공정모티터링",
        slug: "생산공정모티터링",
        showSubmenuOn: '/product',
        popup: true,
        popupComponent: 'page-2-5'
      },
      {
        url: "/product/6",
        name: "CCP 장비모니터링",
        slug: "CCP 장비모니터링",
        showSubmenuOn: '/product',
        popup: true,
        popupComponent: 'page-2-6'
      },
      {
        url: "/product/job-order-attendance",
        name: "생산자 근태기록",
        slug: "생산자 근태기록",
        showSubmenuOn: '/product',
      }
    ]
  },
  {
    url: "/customer",
    name: "거래처정보",
    slug: "거래처정보",
    showSubmenuOn: '/customer',
    submenu: [
      {
        url: "/customer/customer",
        name: "거래처 등록",
        slug: "거래처 등록",
        showSubmenuOn: '/customer',
      },
      {
        url: "/customer/customer-query",
        name: "거래처 조회",
        slug: "거래처 조회",
        showSubmenuOn: '/customer',
      }
    ]
  },
  {
    url: "/stock",
    name: "재고관리",
    slug: "재고관리",
    showSubmenuOn: '/stock',
    submenu: [
      {
        url: "/stock/serial-lot",
        name: "시리얼/Lot 등록",
        slug: "시리얼/Lot 등록",
        showSubmenuOn: '/stock',
      },
      {
        url: "/stock/product-delivery",
        name: "생산불출 등록",
        slug: "생산불출 등록",
        showSubmenuOn: '/stock',
      },
      {
        url: "/stock/statistics",
        name: "창고별 재고현황",
        slug: "창고별 재고현황",
        showSubmenuOn: '/stock',
      },
      {
        url: "/stock/unit-cost",
        name: "품목별 단가정보",
        slug: "품목별 단가정보",
        showSubmenuOn: '/stock',
      }
    ]
  },
  {
    url: "/haccp",
    name: "HACCP모니터링",
    slug: "HACCP모니터링",
    showSubmenuOn: '/haccp',
    submenu: [
      {
        url: "/haccp/ccp-monitoring",
        name: "CCP 모니터링",
        slug: "CCP 모니터링",
        showSubmenuOn: '/haccp',
      },
      {
        url: "/haccp/ccp-limit",
        name: "CCP 이탈한계설정",
        slug: "CCP 이탈한계설정",
        showSubmenuOn: '/haccp',
      },
      {
        url: "/haccp/ccp-escape",
        name: "CCP 이탈정보",
        slug: "CCP 이탈정보",
        showSubmenuOn: '/haccp',
      },
      {
        url: "/haccp/ccp-data-query",
        name: "CCP 자료 조회",
        slug: "CCP 자료 조회",
        showSubmenuOn: '/haccp',
      },
      {
        url: "/haccp/haccp-result",
        name: "HACCP 점검결과",
        slug: "HACCP 점검결과",
        showSubmenuOn: '/haccp',
      },
    ]
  },
  {
    url: "/data",
    name: "자료관리",
    slug: "자료관리",
    showSubmenuOn: '/data',
    submenu: [
      {
        url: "/data/code",
        name: "공통코드 관리",
        slug: "공통코드 관리",
        showSubmenuOn: '/data',
      },
      {
        url: "/data/log-history",
        name: "사용자 로그이력",
        slug: "사용자 로그이력",
        showSubmenuOn: '/data',
      },
    ]
  },
  {
    url: "/profile",
    name: "Profile",
    slug: "Profile",
    showSubmenuOn: '/profile',
    hideMenu: true,
    submenu: [
      // {
      //   url: "/profile/general",
      //   name: "Profile General",
      //   slug: "Profile General",
      //   showSubmenuOn: '/profile',
      // },
      {
        url: "/profile/password",
        name: "비밀번호 변경",
        slug: "비밀번호 변경",
        showSubmenuOn: '/profile',
      },
      {
        url: "/profile/notifications",
        name: "알림",
        slug: "알림",
        showSubmenuOn: '/profile',
      }
    ]
  }
]
