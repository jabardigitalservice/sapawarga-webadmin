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
  public themeCover = [];
  searchKey = '';
  yourLocation = '123 Test Street';
  logoApp = '';
  slideOpts = {
    effect: 'flip',
    autoplay: {
      delay: 3000
    }
  };

  constructor(public navCtrl: NavController, private platform: Platform) {
    this.logoApp = 'assets/icon/logo.png';

    this.themeCover = [
      {
        slide: 'assets/img/bg-home.jpg'
      },
      {
        slide: 'assets/img/slider.jpg'
      },
      {
        slide: 'assets/img/slider1.jpeg'
      }
    ];

    this.appPages = [
      {
        title: 'E-samsat',
        url: 'id.go.bapenda.sambara',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Perizinan',
        url: 'https://dpmptsp.jabarprov.go.id/sicantik/main/pendaftaranbaru ',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Info harga',
        url: 'id.bigio.priangan',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Info lelang',
        url: 'https://lpse.jabarprov.go.id/eproc4',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Survey',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Polling',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Nomor penting',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Administrasi',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Lapor',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Aspirasi',
        url: '',
        icon: 'assets/icon/demo.png'
      }
    ];
  }

  settings() {
    this.navCtrl.navigateForward('settings');
  }

  // Go to layanan
  goToLayanan(app: string, layananUrl: string) {
    if (layananUrl) {
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
        default:
          break;
      }
    }
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
