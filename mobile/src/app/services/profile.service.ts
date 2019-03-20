import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ProfileService {
  constructor(private http: HttpClient) {}

  getProfile() {
    return this.http.get(`${environment.API_URL}/user/me`).pipe(
      catchError(e => {
        let status = e.status;
        if (status === 401) {
          console.log('You are not authorized for this!');
          // this.logout();
        }
        throw new Error(e);
      })
    );
  }
}
