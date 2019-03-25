import { Component, OnInit } from '@angular/core';
import { ProfileService } from 'src/app/services/profile.service';
import { LoadingController, PopoverController } from '@ionic/angular';
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
    public popoverCtrl: PopoverController
  ) {}

  ngOnInit() {
    this.getDataProfile();
  }

  ionViewDidEnter() {
    this.getDataProfile();
  }

  getDataProfile() {
    this.profileService.getProfile().subscribe(
      res => {
        this.dataProfile = res['data'];
      },
      err => {
        console.log(err);
      }
    );
  }

  doRefresh(event) {
    this.getDataProfile();
    // event.target.complete();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }

  async navbarMore(ev: any) {
    const popover = await this.popoverCtrl.create({
      component: MenuNavbarComponent,
      event: ev,
      // animated: true,
      // showBackdrop: true
      translucent: true
    });
    return await popover.present();
  }
}
