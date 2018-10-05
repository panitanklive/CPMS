import { Component, OnInit } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
import { CookieService } from "ngx-cookie-service";
import swal from "sweetalert2";
import { UrlService } from "../url.service";
@Component({
  selector: "app-car",
  templateUrl: "./car.component.html",
  styleUrls: ["./car.component.css"]
})
export class CarComponent implements OnInit {
  car: any[];
  urlbase: string;
  term = "";
  get: any;
  trip_start = "";
  trip_end = "";
  car_brand = [
    { brand: "Bmw" },
    { brand: "Chevrolet" },
    { brand: "Ford" },
    { brand: "Honda" },
    { brand: "Hyundai" },
    { brand: "Isuzu" },
    { brand: "Mazda" },
    { brand: "Mercedez-Benz" },
    { brand: "Mitsubish" },
    { brand: "Nissan" },
    { brand: "Subaru" },
    { brand: "Suzuki" },
    { brand: "Toyota" }
  ];
  constructor(
    private http: HttpClient,
    private router: Router,
    private location: Location,
    public service: UrlService,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService
  ) {
    this.urlbase = service.get_url();
    this.service.nav = "car";
  }

  ngOnInit() {
    this.feed_car();
  }

  feed_car() {
    this.http
      .get<any[]>(this.urlbase + "myconn/car/feed_car.php")
      .subscribe(data => {
        this.car = data;
      });
  }

  feed_car_if() {
    if (
      this.trip_start > this.trip_end ||
      this.trip_start == "" ||
      this.trip_end == ""
    ) {
      swal(
        "วันที่ในการค้นหา",
        "กรุณากรอกวันที่ในการค้นหาให้ถูกต้อง ",
        "warning"
      );
    } else {
      this.http
        .get<any[]>(
          this.urlbase +
            "myconn/car/feed_car_if.php?trip_start=" +
            this.trip_start +
            "&&trip_end=" +
            this.trip_end
        )
        .subscribe(data => {
          this.car = data;
          swal(
            "ค้นหาเรียบร้อย",
            "บนรถยนต์ที่ว่าง " + this.car.length + " คัน",
            "success"
          );
        });
    }
  }

  cancel(carpool_id) {
    swal({
      title: "ต้องการยกเลิกการใช้รถ",
      text: "คลิกตกลงเพื่อยกเลิกการใช้รถ",
      type: "question",
      showCancelButton: true,
      confirmButtonText: "ok"
    }).then(result => {
      if (result.value) {
        this.http
          .get<any[]>(
            this.urlbase + "myconn/car/cancel_car.php?carpool_id=" + carpool_id
          )
          .subscribe(data => {
            this.get = data;
            if (this.get == 1) {
              swal(
                "เรียบร้อย",
                "รถทะเบียน " + carpool_id + " ถูกยกเลิกแล้ว",
                "success"
              );
              this.feed_car();
            } else {
              swal("เกิดปัญหา", "ไม่สามารถยกเลิกการใช้รถคนนี้ได้", "error");
            }
          });
      } else {
        result.dismiss === swal.DismissReason.cancel;
      }
    });
  }

  maintenance(carpool_id) {
    swal({
      title: "ต้องการส่งรถซ่อมหรือไม่",
      text: "คลิกตกลงเพื่อยืนยันการส่งซ่อม",
      type: "question",
      showCancelButton: true,
      confirmButtonText: "ok"
    }).then(result => {
      if (result.value) {
        this.http
          .get<any[]>(
            this.urlbase +
              "myconn/car/maintenance.php?carpool_id=" +
              carpool_id +
              "&&btn=send"
          )
          .subscribe(data => {
            this.get = data;
            if (this.get == 1) {
              swal(
                "เรียบร้อย",
                "รถทะเบียน " + carpool_id + " ถูกส่งซ่อม",
                "success"
              );
              this.feed_car();
            } else {
              swal("เกิดปัญหา", "ไม่สามารถส่งซ่อมรถคนนี้ได้", "error");
            }
          });
      } else {
        result.dismiss === swal.DismissReason.cancel;
      }
    });
  }

  back(carpool_id) {
    swal({
      title: "ต้องการรับรถคืนจากการส่งซ่อมหรือไม่",
      text: "คลิกตกลงเพื่อรับรถคืนจากการส่งซ่อม",
      type: "question",
      showCancelButton: true,
      confirmButtonText: "ok"
    }).then(result => {
      if (result.value) {
        this.http
          .get<any[]>(
            this.urlbase +
              "myconn/car/maintenance.php?carpool_id=" +
              carpool_id +
              "&&btn=back"
          )
          .subscribe(data => {
            this.get = data;
            if (this.get == 1) {
              swal(
                "เรียบร้อย",
                "รถทะเบียน " + carpool_id + " รับคืนแล้ว",
                "success"
              );
              this.feed_car();
            } else {
              swal("เกิดปัญหา", "ไม่สามารถรับคืนรถคันนี้ได้", "error");
            }
          });
      } else {
        result.dismiss === swal.DismissReason.cancel;
      }
    });
  }
}
