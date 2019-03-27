import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { catchError } from 'rxjs/operators';
import { Observable, throwError } from 'rxjs';
import { environment } from '../../environments/environment';
import { Areas } from './../interfaces/areas';

@Injectable({
  providedIn: 'root'
})
export class AreasService {
  constructor(private http: HttpClient) {}

  getKabKota(): Observable<Areas[]> {
    return this.http
      .get<Areas[]>(`${environment.API_URL}/areas?depth=2&all=true`)
      .pipe(catchError(this.handleError));
  }

  getKecamatan(kabkota: number): Observable<Areas[]> {
    return this.http
      .get<Areas[]>(
        `${environment.API_URL}/areas?parent_id=${kabkota}&depth=3&all=true`
      )
      .pipe(catchError(this.handleError));
  }

  getKelurahan(kecamatan): Observable<Areas[]> {
    return this.http
      .get<Areas[]>(
        `${environment.API_URL}/areas?parent_id=${kecamatan}&depth=4&all=true`
      )
      .pipe(catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    if (error.error instanceof ErrorEvent) {
      // A client-side or network error occurred. Handle it accordingly.
      console.error('An error occurred:', error.error.message);
    } else {
      // The backend returned an unsuccessful response code.
      // The response body may contain clues as to what went wrong,
      console.error(
        `Backend returned code ${error.status}, ` + `body was: ${error.error}`
      );
    }
    // return an observable with a user-facing error message
    return throwError(error.error);
  }
}
