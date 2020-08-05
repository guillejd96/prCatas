package com.example.decatas;

import android.graphics.Typeface;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.view.Gravity;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;

public class Resultados extends AppCompatActivity {

    private String idCata,nCervezas;
    public LinearLayout layout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_resultados);

        Bundle bundle = getIntent().getExtras();
        this.idCata = bundle.getString("id");
        this.nCervezas = bundle.getString("n");

        this.layout = (LinearLayout)findViewById(R.id.layout);

        if(Integer.parseInt(this.nCervezas)>0){
            TextView tvMejorCervezaMedia = new TextView(this);
            tvMejorCervezaMedia.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorCervezaMedia.setGravity(Gravity.CENTER);
            tvMejorCervezaMedia.setTextSize(20);
            tvMejorCervezaMedia.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorCervezaMedia.setText(R.string.best_beers);
            layout.addView(tvMejorCervezaMedia);

            Map<String,String> p = new LinkedHashMap<>();
            p.put("id",this.idCata);

            String result="";

            try {
                Connection c = new Connection(this,"getMejoresCervezasMedia.php",p);
                while(c.getRes()==null);
                result = c.getRes();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            }

            if(result.equals("")){
                TextView tv = new TextView(this);
                tv.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
                tv.setGravity(Gravity.CENTER);
                tv.setTextSize(20);
                tv.setText(R.string.no_values_found);

                layout.addView(tv);
            }else {
                // SPLIT RESULT
            }

        }else {
            TextView tv = new TextView(this);
            tv.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tv.setGravity(Gravity.CENTER);
            tv.setTextSize(20);
            tv.setText(R.string.no_beers_in_beer_tasting);

            layout.addView(tv);
        }
    }
}