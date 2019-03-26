import { Component, OnInit } from '@angular/core';
import { ProfileService } from 'src/app/services/profile.service';
import {
  LoadingController,
  PopoverController,
  ToastController,
  Platform
} from '@ionic/angular';
import { Profile } from '../../interfaces/profile';
import { MenuNavbarComponent } from '../../components/menu-navbar/menu-navbar.component';
import { AppAvailability } from '@ionic-native/app-availability/ngx';
import {
  InAppBrowser,
  InAppBrowserObject
} from '@ionic-native/in-app-browser/ngx';

@Component({
  selector: 'app-view-profile',
  templateUrl: './view-profile.page.html',
  styleUrls: ['./view-profile.page.scss']
})
export class ViewProfilePage implements OnInit {
  dataProfile: Profile;

  constructor(
    public loadingCtrl: LoadingController,
    private profileService: ProfileService,
    public popoverCtrl: PopoverController,
    public toastCtrl: ToastController,
    private appAvailability: AppAvailability,
    private platform: Platform,
    private inAppBrowser: InAppBrowser
  ) {}

  ngOnInit() {
    this.getDataProfile(null);
  }

  ionViewDidEnter() {
    this.getDataProfile(null);
  }

  // pass in the app name and the name of the user/page
  goToSosialMedia(app: string, name?: string, fbUrl?: string) {
    if (name) {
      switch (app) {
        case 'facebook':
          this.launchApp(
            'fb://',
            'com.facebook.katana',
            'fb://facewebmodal/f?href=' + fbUrl,
            // url fb
            fbUrl
          );
          break;
        case 'instagram':
          this.launchApp(
            'instagram://',
            'com.instagram.android',
            'instagram://user?username=' + name,
            'https://www.instagram.com/' + name
          );
          break;
        case 'twitter':
          this.launchApp(
            'twitter://',
            'com.twitter.android',
            'twitter://user?screen_name=' + name,
            'https://twitter.com/' + name
          );
          break;
        default:
          break;
      }
    }
  }

  private launchApp(
    iosApp: string,
    androidApp: string,
    appUrl: string,
    webUrl: string
  ) {
    let app: string;
    // check if the platform is ios or android, else open the web url
    if (this.platform.is('ios')) {
      app = iosApp;
    } else if (this.platform.is('android')) {
      app = androidApp;
    } else {
      const browser: InAppBrowserObject = this.inAppBrowser.create(
        webUrl,
        '_system'
      );
      return;
    }
    this.appAvailability.check(app).then(
      () => {
        // success callback, the app exists and we can open it
        const browser: InAppBrowserObject = this.inAppBrowser.create(
          appUrl,
          '_system'
        );
      },
      () => {
        // error callback, the app does not exist, open regular web url instead
        const browser: InAppBrowserObject = this.inAppBrowser.create(
          webUrl,
          '_system'
        );
      }
    );
  }

  async getDataProfile(event) {
    const loader = await this.loadingCtrl.create({
      duration: 10000
    });
    if (event === null) {
      loader.present();
    }
    this.profileService.getProfile().subscribe(
      res => {
        this.dataProfile = res['data'];
        loader.dismiss();
        if (
          !this.dataProfile.twitter ||
          !this.dataProfile.facebook ||
          !this.dataProfile.instagram
        ) {
          this.showToast('Mohon lengkapi akun sosial media anda');
        }
      },
      err => {
        console.log(err);
        loader.dismiss();
      }
    );
  }

  // goToSosialMedia(value: string) {
  //   console.log(value);
  // }

  doRefresh(event) {
    this.getDataProfile('loading');
    // event.target.complete();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }

  async navbarMore(ev: any) {
    // console.log(ev);
    const popover = await this.popoverCtrl.create({
      component: MenuNavbarComponent,
      componentProps: {
        dataUser: ev
      },
      event: ev,
      cssClass: 'popover_class',
      animated: true,
      showBackdrop: true,
      translucent: true
    });

    popover.onDidDismiss();

    return await popover.present();
  }

  async showToast(msg: string) {
    const toast = await this.toastCtrl.create({
      message: msg,
      duration: 2000
    });
    toast.present();
  }
}
