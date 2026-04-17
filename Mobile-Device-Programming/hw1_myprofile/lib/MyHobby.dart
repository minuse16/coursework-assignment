import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class MyHobby extends StatelessWidget {
  const MyHobby({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Text('\n'),
          Row(mainAxisAlignment: MainAxisAlignment.center, children: [
            Icon(
              Icons.audiotrack_rounded,
              color: Color(0xFF873FA8),
              size: 32,
            ),
            Text(' : ฟังเพลง',
                style: GoogleFonts.mitr(
                    fontSize: 18, fontWeight: FontWeight.w300)),
          ]),
          Text('\n'),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                Icons.sports_esports_rounded,
                color: Color(0xFF873FA8),
                size: 32,
              ),
              Text(' : เล่นเกม',
                  style: GoogleFonts.mitr(
                      fontSize: 18, fontWeight: FontWeight.w300))
            ],
          ),
          Text('\n'),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                Icons.live_tv_rounded,
                color: Color(0xFF873FA8),
                size: 32,
              ),
              Text(
                ' : ดูซีรีส์',
                style:
                    GoogleFonts.mitr(fontSize: 18, fontWeight: FontWeight.w300),
              )
            ],
          ),
          Text('\n'),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                Icons.local_grocery_store_rounded,
                color: Color(0xFF873FA8),
                size: 32,
              ),
              Text(
                ' : ช็อปปิ้ง',
                style:
                    GoogleFonts.mitr(fontSize: 18, fontWeight: FontWeight.w300),
              )
            ],
          ),
          Text('\n'),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                Icons.pets_rounded,
                color: Color(0xFF873FA8),
                size: 32,
              ),
              Text(
                ' : เลี้ยงแมว',
                style:
                    GoogleFonts.mitr(fontSize: 18, fontWeight: FontWeight.w300),
              )
            ],
          )
        ],
      ),
    );
  }
}
