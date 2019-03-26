import { Component, OnInit } from '@angular/core';
import { ProfileService } from 'src/app/services/profile.service';
import {
  LoadingController,
  PopoverController,
  ToastController
} from '@ionic/angular';
import { Profile } from '../../interfaces/profile';
import { MenuNavbarComponent } from '../../components/menu-navbar/menu-navbar.component';

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
    public toastCtrl: ToastController
  ) {}

  ngOnInit() {
    this.getDataProfile(null);
    if (this.dataProfile) {
      this.showToast('Sosial Media', 'Mohon lengkapi akun sosial media anda');
    }
  }

  ionViewDidEnter() {
    this.getDataProfile(null);
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
      },
      err => {
        console.log(err);
        loader.dismiss();
      }
    );
  }

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
      animated: true,
      showBackdrop: true,
      translucent: true
    });

    popover.onDidDismiss();

    return await popover.present();
  }

  goToSosialMedia(value: string) {
    console.log(value);
  }

  async showToast(title: string, msg: string) {
    const toast = await this.toastCtrl.create({
      message: msg,
      duration: 2000
    });
    toast.present();
  }
}
