import { Component } from '@angular/core';
import { NavController, Platform } from '@ionic/angular';

import { Pages } from '../../interfaces/pages';

@Component({
  selector: 'app-home-results',
  templateUrl: './home-results.page.html',
  styleUrls: ['./home-results.page.scss']
})
export class HomeResultsPage {
  public appPages: Array<Pages>;
  themeCover = [
    {
      slide: 'assets/img/banner-01.png'
    },
    {
      slide: 'assets/img/banner-02.png'
    }
  ];
  logoApp = 'assets/icon/logo.png';
  slideOpts = {
    effect: 'flip',
    autoplay: {
      delay: 3000
    }
  };

  constructor(public navCtrl: NavController, private platform: Platform) {
    this.appPages = [
      {
        title: 'E-samsat',
        url: 'id.go.bapenda.sambara',
        icon: 'assets/icon/SW-E-samsat.png'
      },
      {
        title: 'Perizinan',
        url: 'https://dpmptsp.jabarprov.go.id/sicantik/main/pendaftaranbaru ',
        icon: 'assets/icon/SW-IJIN.png'
      },
      {
        title: 'Info harga',
        url: 'id.bigio.priangan',
        icon: 'assets/icon/SW-Info-harga.png'
      },
      {
        title: 'Info lelang',
        url: 'https://lpse.jabarprov.go.id/eproc4',
        icon: 'assets/icon/SW-LELANG.png'
      },
      {
        title: 'Survey',
        url: '',
        icon: 'assets/icon/SW-SURVEY.png'
      },
      {
        title: 'Polling',
        url: '',
        icon: 'assets/icon/SW-POLLING.png'
      },
      {
        title: 'Nomor penting',
        url: '',
        icon: 'assets/icon/SW-NOPENTING.png'
      },
      {
        title: 'Administrasi',
        url: '',
        icon: 'assets/icon/SW-ADMINISTRASI.png'
      },
      {
        title: 'Lapor',
        url: '',
        icon: 'assets/icon/SW-LELANG.png'
      },
      {
        title: 'Aspirasi',
        url: '',
        icon: 'assets/icon/SW-LELANG.png'
      }
    ];
  }

  settings() {
    this.navCtrl.navigateForward('settings');
  }

  // Go to layanan
  goToLayanan(app: string, layananUrl: string) {
    switch (app) {
      case 'E-samsat':
        this.launchApp(layananUrl);
        break;
      case 'Perizinan':
        this.launchApp(layananUrl);
        break;
      case 'Info harga':
        this.launchApp(layananUrl);
        break;
      case 'Info lelang':
        this.launchApp(layananUrl);
        break;
      case 'Nomor penting':
        this.goNomorPenting();
        break;
      default:
        break;
    }
  }

  goNomorPenting() {
    this.navCtrl.navigateForward('nomor-penting');
  }

  // call function launchApp to open external app
  private launchApp(appUrl: string) {
    // check if the platform is ios or android, else open the web url
    if (this.platform.is('android')) {
      let appId = appUrl;
      let appStarter = (window as any).startApp.set({ application: appId });
      appStarter.start(
        function(msg) {},
        function(err) {
          window.open(`market://details?id=${appId}`, '_system');
        }
      );
    }
  }
}
