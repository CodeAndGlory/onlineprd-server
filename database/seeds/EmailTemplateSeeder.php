<?php

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'name' => 'UNCGO address',
                'body' => '<p><strong>Division of Online Learning</strong></p><p>Becher-Weaver Building<br>915 Northridge Street<br>PO Box 26170<br>Greensboro, NC 27402-6170</p><p>336.315.7044 Phone&nbsp;&nbsp;&nbsp;&nbsp;336.315.7767 Fax</p><p>online.uncg.edu</p>',
            ],
            [
                'name' => 'opening',
                'body' => '<p>On behalf of Provost Dana Dunn, I am pleased to offer you an appointment in the 2020 Summer Session of UNC Greensboro. Your assignment(s) and stipend(s) will be:</p>',
            ],
            [
                'name' => 'ad-pay',
                'body' => '<p>This appointment is to be performed outside of your normal working hours, responsibilities and duties. You will be paid by direct deposit for the days worked in June, July or August on the last day of each month. Salary caps and overloads are the responsibility of your home department. For current or returning employees, please verify or update your direct deposit information via UNCGenie self-service. For new employees, once you receive your University ID #, please login to UNCGenie self-service at <span style="color: rgb(0, 0, 255);">https://ssb.uncg.edu/prod/twbkwbis.P_WWWLogin </span>to enroll in the direct deposit program.</p>',
            ],
            [
                'name' => 'enrollment disclaimer',
                'body' => '<p>This offer is expressly contingent upon adequate course enrollment and funds being made available to the Division of Online Learning in the amount adequate to support your employment at the salary specified in this letter (including benefits). If, in the sole determination of the University, adequate funds are not available on your first work date, this offer shall be rendered null and void. It is further understood that there are no oral or written agreements regarding the salary associated with this appointment other than those contained in or expressly incorporated by reference into this letter of appointment. Minimum enrollment limits will be 10 for graduate and 15 for undergraduate courses.</p>',
            ],
            [
                'name' => 'instructions',
                'body' => '<p>Please complete and submit your acceptance by providing your e-signature on the electronic acceptance form at [acceptance_form_url] by April 09, 2020. Your payment cannot be processed without your acceptance of this contract.</p>',
            ],
            [
                'name' => 'questions contact',
                'body' => '<p>If you have any questions, please feel free to contact Sharon Nash-Sellars by phone (336) 315-7784 or email <a href="mailto:sharon_nash_sellars@uncg.edu" rel="noopener noreferrer" target="_blank">sharon_nash_sellars@uncg.edu</a><span style="color: rgb(0, 0, 0);">.</span></p>',
            ],
            [
                'name' => 'dean name',
                'body' => '<p>Karen Z. Bull, Ph.D.</p><p>Dean, Division of Online Learning</p>',
            ],
            [
                'name' => 'initials',
                'body' => '<p>KZB/bnj</p>',
            ]
        ];

        foreach ($templates as $template) {
            EmailTemplate::firstOrCreate(
                $template
            );
        }
    }
}
