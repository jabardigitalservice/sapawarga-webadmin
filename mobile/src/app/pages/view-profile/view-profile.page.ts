import { Component, OnInit } from '@angular/core';
import { ProfileService } from 'src/app/services/profile.service';
import { LoadingController } from '@ionic/angular';
import { Profile } from '../../interfaces/profile';

@Component({
  selector: 'app-view-profile',
  templateUrl: './view-profile.page.html',
  styleUrls: ['./view-profile.page.scss']
})
export class ViewProfilePage implements OnInit {
  dataProfile: Profile;

  constructor(
    public loadingCtrl: LoadingController,
    private profileService: ProfileService
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
}
