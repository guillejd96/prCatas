package com.example.decatas;

import android.graphics.Typeface;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TableRow;
import android.widget.TextView;

import java.net.MalformedURLException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.LinkedHashMap;
import java.util.LinkedList;
import java.util.List;
import java.util.Map;
import java.util.stream.Collectors;

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
                String[] cs = result.split(";");
                Map<String,Float> cervezasMedia = new LinkedHashMap<>();
                for(String c : cs){
                    String[] info = c.split(",");
                    cervezasMedia.put(info[0],Float.valueOf(info[1]));
                }
                cervezasMedia = sortByComparator(cervezasMedia,false);
                int i=1;
                for(Map.Entry<String,Float> entry : cervezasMedia.entrySet()){
                    String id = entry.getKey();
                    Float media = entry.getValue();

                    Map<String,String> params = new LinkedHashMap<>();
                    params.put("id",id);
                    Connection c = null;
                    try {
                        c = new Connection(this,"getNombreCervezaByID.php",params);
                    } catch (MalformedURLException e) {
                        e.printStackTrace();
                    }
                    while (c.getRes()==null);
                    String nombreCerveza = c.getRes();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombreCerveza+" ("+media+")");
                    trTD.addView(tv1);

                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorCervezaAroma = new TextView(this);
            tvMejorCervezaAroma.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorCervezaAroma.setGravity(Gravity.CENTER);
            tvMejorCervezaAroma.setTextSize(20);
            tvMejorCervezaAroma.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorCervezaAroma.setText(R.string.best_beers_smell);
            layout.addView(tvMejorCervezaAroma);

            result="";

            try {
                Connection c = new Connection(this,"getMejoresCervezasAroma.php",p);
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
                String[] cs = result.split(";");
                Map<String,Float> cervezasAroma = new LinkedHashMap<>();
                for(String c : cs){
                    String[] info = c.split(",");
                    cervezasAroma.put(info[0],Float.valueOf(info[1]));
                }
                cervezasAroma = sortByComparator(cervezasAroma,false);
                int i=1;
                for(Map.Entry<String,Float> entry : cervezasAroma.entrySet()){
                    String id = entry.getKey();
                    Float aroma = entry.getValue();

                    Map<String,String> params = new LinkedHashMap<>();
                    params.put("id",id);
                    Connection c = null;
                    try {
                        c = new Connection(this,"getNombreCervezaByID.php",params);
                    } catch (MalformedURLException e) {
                        e.printStackTrace();
                    }
                    while (c.getRes()==null);
                    String nombreCerveza = c.getRes();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombreCerveza+" ("+aroma+")");
                    trTD.addView(tv1);

                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorCervezaApariencia = new TextView(this);
            tvMejorCervezaApariencia.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorCervezaApariencia.setGravity(Gravity.CENTER);
            tvMejorCervezaApariencia.setTextSize(20);
            tvMejorCervezaApariencia.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorCervezaApariencia.setText(R.string.best_beers_aparience);
            layout.addView(tvMejorCervezaApariencia);

            result="";

            try {
                Connection c = new Connection(this,"getMejoresCervezasApariencia.php",p);
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
                String[] cs = result.split(";");
                Map<String,Float> cervezasApariencia = new LinkedHashMap<>();
                for(String c : cs){
                    String[] info = c.split(",");
                    cervezasApariencia.put(info[0],Float.valueOf(info[1]));
                }
                cervezasApariencia = sortByComparator(cervezasApariencia,false);
                int i=1;
                for(Map.Entry<String,Float> entry : cervezasApariencia.entrySet()){
                    String id = entry.getKey();
                    Float apariencia = entry.getValue();

                    Map<String,String> params = new LinkedHashMap<>();
                    params.put("id",id);
                    Connection c = null;
                    try {
                        c = new Connection(this,"getNombreCervezaByID.php",params);
                    } catch (MalformedURLException e) {
                        e.printStackTrace();
                    }
                    while (c.getRes()==null);
                    String nombreCerveza = c.getRes();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombreCerveza+" ("+apariencia+")");
                    trTD.addView(tv1);

                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorCervezaSabor = new TextView(this);
            tvMejorCervezaSabor.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorCervezaSabor.setGravity(Gravity.CENTER);
            tvMejorCervezaSabor.setTextSize(20);
            tvMejorCervezaSabor.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorCervezaSabor.setText(R.string.best_beers_taste);
            layout.addView(tvMejorCervezaSabor);

            result="";

            try {
                Connection c = new Connection(this,"getMejoresCervezasSabor.php",p);
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
                String[] cs = result.split(";");
                Map<String,Float> cervezasSabor = new LinkedHashMap<>();
                for(String c : cs){
                    String[] info = c.split(",");
                    cervezasSabor.put(info[0],Float.valueOf(info[1]));
                }
                cervezasSabor = sortByComparator(cervezasSabor,false);
                int i=1;
                for(Map.Entry<String,Float> entry : cervezasSabor.entrySet()){
                    String id = entry.getKey();
                    Float sabor = entry.getValue();

                    Map<String,String> params = new LinkedHashMap<>();
                    params.put("id",id);
                    Connection c = null;
                    try {
                        c = new Connection(this,"getNombreCervezaByID.php",params);
                    } catch (MalformedURLException e) {
                        e.printStackTrace();
                    }
                    while (c.getRes()==null);
                    String nombreCerveza = c.getRes();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombreCerveza+" ("+sabor+")");
                    trTD.addView(tv1);

                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorCervezaCuerpo = new TextView(this);
            tvMejorCervezaCuerpo.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorCervezaCuerpo.setGravity(Gravity.CENTER);
            tvMejorCervezaCuerpo.setTextSize(20);
            tvMejorCervezaCuerpo.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorCervezaCuerpo.setText(R.string.best_beers_body);
            layout.addView(tvMejorCervezaCuerpo);

            result="";

            try {
                Connection c = new Connection(this,"getMejoresCervezasCuerpo.php",p);
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
                String[] cs = result.split(";");
                Map<String,Float> cervezasCuerpo = new LinkedHashMap<>();
                for(String c : cs){
                    String[] info = c.split(",");
                    cervezasCuerpo.put(info[0],Float.valueOf(info[1]));
                }
                cervezasCuerpo = sortByComparator(cervezasCuerpo,false);
                int i=1;
                for(Map.Entry<String,Float> entry : cervezasCuerpo.entrySet()){
                    String id = entry.getKey();
                    Float cuerpo = entry.getValue();

                    Map<String,String> params = new LinkedHashMap<>();
                    params.put("id",id);
                    Connection c = null;
                    try {
                        c = new Connection(this,"getNombreCervezaByID.php",params);
                    } catch (MalformedURLException e) {
                        e.printStackTrace();
                    }
                    while (c.getRes()==null);
                    String nombreCerveza = c.getRes();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombreCerveza+" ("+cuerpo+")");
                    trTD.addView(tv1);

                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorCervezaBotellin = new TextView(this);
            tvMejorCervezaBotellin.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorCervezaBotellin.setGravity(Gravity.CENTER);
            tvMejorCervezaBotellin.setTextSize(20);
            tvMejorCervezaBotellin.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorCervezaBotellin.setText(R.string.best_beers_bottle);
            layout.addView(tvMejorCervezaBotellin);

            result="";

            try {
                Connection c = new Connection(this,"getMejoresCervezasBotellin.php",p);
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
                String[] cs = result.split(";");
                Map<String,Float> cervezasBotellin = new LinkedHashMap<>();
                for(String c : cs){
                    String[] info = c.split(",");
                    cervezasBotellin.put(info[0],Float.valueOf(info[1]));
                }
                cervezasBotellin = sortByComparator(cervezasBotellin,false);
                int i=1;
                for(Map.Entry<String,Float> entry : cervezasBotellin.entrySet()){
                    String id = entry.getKey();
                    Float botellin = entry.getValue();

                    Map<String,String> params = new LinkedHashMap<>();
                    params.put("id",id);
                    Connection c = null;
                    try {
                        c = new Connection(this,"getNombreCervezaByID.php",params);
                    } catch (MalformedURLException e) {
                        e.printStackTrace();
                    }
                    while (c.getRes()==null);
                    String nombreCerveza = c.getRes();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombreCerveza+" ("+botellin+")");
                    trTD.addView(tv1);
                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorJuezMedia = new TextView(this);
            tvMejorJuezMedia.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorJuezMedia.setGravity(Gravity.CENTER);
            tvMejorJuezMedia.setTextSize(20);
            tvMejorJuezMedia.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorJuezMedia.setText(R.string.best_judge_average);
            layout.addView(tvMejorJuezMedia);

            p = new LinkedHashMap<>();
            p.put("id",idCata);
            result="";
            try {
                Connection c = new Connection(this,"getMejoresJuecesMedia.php",p);
                while(c.getRes()==null);
                result=c.getRes();
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
                String[] cer = result.split(";");
                Map<String,Float> personasMedia = new LinkedHashMap<>();
                for(String c : cer){
                    String[] info = c.split(",");
                    personasMedia.put(info[0],Float.valueOf(info[1]));
                }

                personasMedia = sortByComparator(personasMedia,true);
                int i=1;
                for(Map.Entry<String,Float> entry : personasMedia.entrySet()){
                    String nombre = entry.getKey();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombre);
                    trTD.addView(tv1);
                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorJuezAroma = new TextView(this);
            tvMejorJuezAroma.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorJuezAroma.setGravity(Gravity.CENTER);
            tvMejorJuezAroma.setTextSize(20);
            tvMejorJuezAroma.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorJuezAroma.setText(R.string.best_judge_smell);
            layout.addView(tvMejorJuezAroma);

            p = new LinkedHashMap<>();
            p.put("id",idCata);
            result="";
            try {
                Connection c = new Connection(this,"getMejoresJuecesAroma.php",p);
                while(c.getRes()==null);
                result=c.getRes();
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
                String[] cer = result.split(";");
                Map<String,Float> personasAroma = new LinkedHashMap<>();
                for(String c : cer){
                    String[] info = c.split(",");
                    personasAroma.put(info[0],Float.valueOf(info[1]));
                }

                personasAroma = sortByComparator(personasAroma,true);
                int i=1;
                for(Map.Entry<String,Float> entry : personasAroma.entrySet()){
                    String nombre = entry.getKey();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombre);
                    trTD.addView(tv1);
                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorJuezApariencia = new TextView(this);
            tvMejorJuezApariencia.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorJuezApariencia.setGravity(Gravity.CENTER);
            tvMejorJuezApariencia.setTextSize(20);
            tvMejorJuezApariencia.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorJuezApariencia.setText(R.string.best_judge_appearance);
            layout.addView(tvMejorJuezApariencia);

            p = new LinkedHashMap<>();
            p.put("id",idCata);
            result="";
            try {
                Connection c = new Connection(this,"getMejoresJuecesApariencia.php",p);
                while(c.getRes()==null);
                result=c.getRes();
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
                String[] cer = result.split(";");
                Map<String,Float> personasApariencia = new LinkedHashMap<>();
                for(String c : cer){
                    String[] info = c.split(",");
                    personasApariencia.put(info[0],Float.valueOf(info[1]));
                }

                personasApariencia = sortByComparator(personasApariencia,true);
                int i=1;
                for(Map.Entry<String,Float> entry : personasApariencia.entrySet()){
                    String nombre = entry.getKey();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombre);
                    trTD.addView(tv1);
                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorJuezSabor = new TextView(this);
            tvMejorJuezSabor.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorJuezSabor.setGravity(Gravity.CENTER);
            tvMejorJuezSabor.setTextSize(20);
            tvMejorJuezSabor.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorJuezSabor.setText(R.string.best_judge_taste);
            layout.addView(tvMejorJuezSabor);

            p = new LinkedHashMap<>();
            p.put("id",idCata);
            result="";
            try {
                Connection c = new Connection(this,"getMejoresJuecesSabor.php",p);
                while(c.getRes()==null);
                result=c.getRes();
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
                String[] cer = result.split(";");
                Map<String,Float> personasSabor = new LinkedHashMap<>();
                for(String c : cer){
                    String[] info = c.split(",");
                    personasSabor.put(info[0],Float.valueOf(info[1]));
                }

                personasSabor = sortByComparator(personasSabor,true);
                int i=1;
                for(Map.Entry<String,Float> entry : personasSabor.entrySet()){
                    String nombre = entry.getKey();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombre);
                    trTD.addView(tv1);
                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorJuezCuerpo = new TextView(this);
            tvMejorJuezCuerpo.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorJuezCuerpo.setGravity(Gravity.CENTER);
            tvMejorJuezCuerpo.setTextSize(20);
            tvMejorJuezCuerpo.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorJuezCuerpo.setText(R.string.best_judge_body);
            layout.addView(tvMejorJuezCuerpo);

            p = new LinkedHashMap<>();
            p.put("id",idCata);
            result="";
            try {
                Connection c = new Connection(this,"getMejoresJuecesCuerpo.php",p);
                while(c.getRes()==null);
                result=c.getRes();
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
                String[] cer = result.split(";");
                Map<String,Float> personasCuerpo = new LinkedHashMap<>();
                for(String c : cer){
                    String[] info = c.split(",");
                    personasCuerpo.put(info[0],Float.valueOf(info[1]));
                }

                personasCuerpo = sortByComparator(personasCuerpo,true);
                int i=1;
                for(Map.Entry<String,Float> entry : personasCuerpo.entrySet()){
                    String nombre = entry.getKey();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombre);
                    trTD.addView(tv1);
                    layout.addView(trTD);
                    i++;
                }
            }

            TextView tvMejorJuezBotellin = new TextView(this);
            tvMejorJuezBotellin.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tvMejorJuezBotellin.setGravity(Gravity.CENTER);
            tvMejorJuezBotellin.setTextSize(20);
            tvMejorJuezBotellin.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            tvMejorJuezBotellin.setText(R.string.best_judge_bottle);
            layout.addView(tvMejorJuezBotellin);

            p = new LinkedHashMap<>();
            p.put("id",idCata);
            result="";
            try {
                Connection c = new Connection(this,"getMejoresJuecesBotellin.php",p);
                while(c.getRes()==null);
                result=c.getRes();
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
                String[] cer = result.split(";");
                Map<String,Float> personasBotellin = new LinkedHashMap<>();
                for(String c : cer){
                    String[] info = c.split(",");
                    personasBotellin.put(info[0],Float.valueOf(info[1]));
                }

                personasBotellin = sortByComparator(personasBotellin,true);
                int i=1;
                for(Map.Entry<String,Float> entry : personasBotellin.entrySet()){
                    String nombre = entry.getKey();

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(i+"º - "+nombre);
                    trTD.addView(tv1);
                    layout.addView(trTD);
                    i++;
                }
            }


            // ULTIMA LINEA
            TextView aux = new TextView(this);
            aux.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            aux.setGravity(Gravity.CENTER);
            aux.setTextSize(20);
            aux.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            aux.setText("");
            layout.addView(aux);

            aux = new TextView(this);
            aux.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            aux.setGravity(Gravity.CENTER);
            aux.setTextSize(20);
            aux.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            aux.setText("");
            layout.addView(aux);

        }else {
            TextView tv = new TextView(this);
            tv.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.FILL_PARENT));
            tv.setGravity(Gravity.CENTER);
            tv.setTextSize(20);
            tv.setText(R.string.no_beers_in_beer_tasting);

            layout.addView(tv);
        }
    }

    private static Map<String, Float> sortByComparator(Map<String, Float> unsortMap, final boolean order){
        List<Map.Entry<String, Float>> list = new LinkedList<>(unsortMap.entrySet());
        Collections.sort(list, new Comparator<Map.Entry<String, Float>>()
        {
            public int compare(Map.Entry<String, Float> o1,
                               Map.Entry<String, Float> o2)
            {
                if (order) return o1.getValue().compareTo(o2.getValue());
                else return o2.getValue().compareTo(o1.getValue());
            }
        });
        Map<String, Float> sortedMap = new LinkedHashMap<>();
        for (Map.Entry<String, Float> entry : list)
        {
            sortedMap.put(entry.getKey(), entry.getValue());
        }
        return sortedMap;
    }
}