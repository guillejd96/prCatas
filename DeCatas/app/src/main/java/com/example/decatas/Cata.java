package com.example.decatas;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Build;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import org.w3c.dom.Text;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;
import java.util.Objects;

public class Cata extends AppCompatActivity {

    private String idUsuario, idPersona, idCata, nombreCata, idAdmin, nCervezas, nPersonas;
    public TextView title,admin;
    public EditText editNuevaCerveza;
    public Button btn;
    public TableLayout table1;
    public TableRow[] personas;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cata);

        Bundle bundle = getIntent().getExtras();
        this.idUsuario = bundle.getString("idUsuario");
        this.idCata = bundle.getString("idCata");

        this.title = (TextView) findViewById(R.id.title);
        this.editNuevaCerveza = (EditText) findViewById(R.id.editTextTextBeerName);
        this.btn = (Button) findViewById(R.id.add);
        this.table1 = (TableLayout) findViewById(R.id.table1);
        this.admin = (TextView) findViewById(R.id.admin);

        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        try {
            Connection pe = new Connection(this,"getIDPersona.php",params);
            while(pe.getRes()==null);
            this.idPersona=pe.getRes().toString();
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }

        Map<String, String> p = new LinkedHashMap<>();
        p.put("id", idCata);
        Connection con = null;
        try {
            con = new Connection(this, "getNPersonas.php", p);
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
        while (con.getRes() == null) ;
        this.nPersonas = con.getRes();

        p = new LinkedHashMap<>();
        p.put("id", idCata);
        con = null;
        try {
            con = new Connection(this, "getNCervezas.php", p);
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
        while (con.getRes() == null) ;
        this.nCervezas = con.getRes();

        this.update(null);
    }

    public void add(View v) throws MalformedURLException {
        editNuevaCerveza.setBackgroundResource(R.drawable.input_normal);

        String beerName = editNuevaCerveza.getText().toString();

        if (!beerName.equals("")) {
            Map<String, String> params = new LinkedHashMap<>();
            params.put("n", beerName);
            params.put("id", idCata);
            Connection con = new Connection(this, "createCerveza.php", params);
            while (con.getRes() == null) ;
            String result = con.getRes();
            if (result.equals("1")) {
                update(v);
            } else {
                Toast.makeText(this, "No se ha podido añadir la cerveza", Toast.LENGTH_LONG).show();
            }
        } else {
            Toast.makeText(this, "Introduce el nombre de una cerveza", Toast.LENGTH_LONG).show();
            editNuevaCerveza.setBackgroundResource(R.drawable.input_error);
        }


    }

    public void update(View view) {
        table1.removeAllViews();
        Map<String, String> p = new LinkedHashMap<>();
        p.put("id", idCata);
        Connection con = null;
        try {
            con = new Connection(this, "getNCervezas.php", p);
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
        while (con.getRes() == null) ;
        this.nCervezas = con.getRes();

        Map<String, String> params = new LinkedHashMap<>();
        params.put("id", idCata);

        try {
            Connection conn = new Connection(this, "getCata.php", params);
            while (conn.getRes() == null) ;
            String result = conn.getRes();
            if (result.equals("0")) {
                Toast.makeText(this, "No se pudo cargar la cata", Toast.LENGTH_LONG).show();
            } else {
                String[] res = result.split("/");
                String aux = res[0];
                String[] infoCata = aux.split(",");
                this.nombreCata = infoCata[0];
                this.idAdmin = infoCata[1];

                title.setText(nombreCata);

                if (idUsuario.equals(idAdmin)) {
                    editNuevaCerveza.setVisibility(View.VISIBLE);
                    btn.setVisibility(View.VISIBLE);
                    admin.setVisibility(View.INVISIBLE);
                } else {
                    editNuevaCerveza.setVisibility(View.INVISIBLE);
                    btn.setVisibility(View.INVISIBLE);

                    Map<String,String> pa = new LinkedHashMap<>();
                    pa.put("id",idAdmin);
                    Connection c = new Connection(this,"getAdmin.php",pa);
                    while(c.getRes()==null);
                    String usuarioAdmin = c.getRes().toString();
                    admin.setText("Admin: "+usuarioAdmin);
                    admin.setTextSize(20);
                    admin.setVisibility(View.VISIBLE);
                }

                table1.removeAllViews();

                TableRow trTH = new TableRow(this);

                trTH.setGravity(Gravity.CENTER);

                trTH.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                trTH.setVisibility(View.VISIBLE);

                trTH.setTag(getResources().getString(R.string.participants));

                TextView tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10, 10, 10, 10);
                tv.setTextSize(20);
                tv.setText(R.string.participants);

                trTH.addView(tv);

                table1.addView(trTH);

                aux = res[1];
                String[] infoPersonas = aux.split(";");

                personas = new TableRow[infoPersonas.length];

                for (int i = 0; i < infoPersonas.length; i++) {
                    String row = infoPersonas[i];
                    String[] infoPersona = row.split(",");

                    String idPersona = infoPersona[0];
                    String nombre = infoPersona[1];
                    String usuario = infoPersona[2];
                    String nC = infoPersona[3];

                    personas[i] = new TableRow(this);

                    personas[i].setGravity(Gravity.CENTER);

                    personas[i].setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    personas[i].setVisibility(View.VISIBLE);


                    final TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10, 10, 10, 10);
                    tv1.setTextSize(20);
                    tv1.setVisibility(View.VISIBLE);
                    String text = nombre + "(" + usuario + "): " + nC + "/" + nCervezas + " valoraciones";
                    tv1.setText(text);
                    tv1.setCompoundDrawablesWithIntrinsicBounds(getResources().getDrawable(R.drawable.ic_arrow_rigth_foreground), null, null, null);

                    Listener1 l = new Listener1(i, idPersona);
                    tv1.setOnClickListener(l);

                    personas[i].setTag(idPersona);

                    personas[i].addView(tv1);

                    table1.addView(personas[i]);
                }

                trTH = new TableRow(this);

                trTH.setGravity(Gravity.CENTER);

                trTH.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                trTH.setVisibility(View.VISIBLE);

                trTH.setTag(getResources().getString(R.string.beers));

                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10, 20, 10, 10);
                tv.setTextSize(20);
                tv.setText(R.string.beers);

                trTH.addView(tv);

                table1.addView(trTH);

                if (res.length > 2) {
                    aux = res[2];
                    String[] infoCervezas = aux.split(";");

                    for (int i = 0; i < infoCervezas.length; i++) {
                        String cad = infoCervezas[i];

                        String cerveza[] = cad.split(",");

                        final String idCerveza = cerveza[0];
                        String nombre = cerveza[1];

                        TableRow trTD = new TableRow(this);

                        trTD.setGravity(Gravity.CENTER);

                        trTD.setLayoutParams(new TableRow.LayoutParams(
                                TableRow.LayoutParams.FILL_PARENT,
                                TableRow.LayoutParams.WRAP_CONTENT));

                        trTD.setVisibility(View.VISIBLE);

                        trTD.setTag(nombre);

                        TextView tv1 = new TextView(this);

                        tv1.setLayoutParams(new TableRow.LayoutParams(
                                TableRow.LayoutParams.FILL_PARENT,
                                TableRow.LayoutParams.WRAP_CONTENT
                        ));

                        tv1.setGravity(Gravity.CENTER);
                        tv1.setPadding(10, 10, 10, 10);
                        tv1.setTextSize(20);
                        tv1.setVisibility(View.VISIBLE);
                        tv1.setText(nombre);

                        tv1.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                Intent intent = new Intent(getApplicationContext(), Valorar_Cerveza.class);
                                intent.putExtra("id", idUsuario);
                                intent.putExtra("c", idCerveza);
                                intent.putExtra("ca", idCata);
                                startActivity(intent);
                            }
                        });

                        params = new LinkedHashMap<>();
                        params.put("p", idPersona);
                        params.put("id", idCerveza);
                        try {
                            con = new Connection(getApplicationContext(), "getOpiniones.php", params);
                            while (con.getRes() == null) ;
                            result = con.getRes();
                            if (!result.equals(""))
                                tv1.setTextColor(getResources().getColor(R.color.green));
                            else tv1.setTextColor(getResources().getColor(R.color.red));
                        } catch (MalformedURLException e) {
                            e.printStackTrace();
                        }

                        trTD.addView(tv1);


                        table1.addView(trTD);
                    }
                } else {
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
                    tv1.setText(R.string.no_beers);
                    trTD.addView(tv1);

                    table1.addView(trTD);
                }
            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void onBackPressed() {
        android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(this);
        builder.setCancelable(true);
        builder.setMessage(getResources().getString(R.string.question_exit_beer_tasting));
        builder.setPositiveButton(R.string.ok, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
                Intent intent = new Intent(getApplicationContext(), User.class);
                intent.putExtra("id", idUsuario);
                startActivity(intent);
            }
        });
        builder.setNegativeButton(R.string.cancel, null);
        builder.show();
    }

    private class Listener1 implements View.OnClickListener {

        int i;
        String idP;

        public Listener1(int i, String s) {
            this.i = i;
            this.idP = s;
        }

        @Override
        public void onClick(View v) {
            TextView tv = (TextView) personas[i].getChildAt(0);
            tv.setCompoundDrawablesWithIntrinsicBounds(getResources().getDrawable(R.drawable.ic_arrow_down_foreground), null, null, null);
            Listener2 l2 = new Listener2(this.i, this.idP);
            tv.setOnClickListener(l2);

            Map<String, String> params = new LinkedHashMap<>();
            params.put("id", idCata);

            try {
                Connection con = new Connection(getApplicationContext(), "getCervezasCata.php", params);
                while (con.getRes() == null) ;
                String result = con.getRes();
                if (!result.equals("")) {
                    String[] aux = result.split(";");
                    for (String c : aux) {
                        String[] cerveza = c.split(",");
                        String idCerveza = cerveza[0];
                        String nombreCerveza = cerveza[1];

                        TableRow tr = new TableRow(getApplicationContext());

                        tr.setGravity(Gravity.CENTER);

                        tr.setLayoutParams(new TableRow.LayoutParams(
                                TableRow.LayoutParams.FILL_PARENT,
                                TableRow.LayoutParams.FILL_PARENT));

                        tr.setVisibility(View.VISIBLE);

                        String tag = idP + "_desplegable";
                        tr.setTag(tag);


                        TextView tvC = new TextView(getApplicationContext());

                        tvC.setLayoutParams(new TableRow.LayoutParams(
                                TableRow.LayoutParams.FILL_PARENT,
                                TableRow.LayoutParams.WRAP_CONTENT
                        ));
                        tvC.setGravity(Gravity.CENTER);
                        tvC.setVisibility(View.VISIBLE);
                        tvC.setPadding(10, 10, 10, 10);
                        tvC.setTextSize(20);
                        tvC.setText(nombreCerveza);

                        params = new LinkedHashMap<>();
                        params.put("p", this.idP);
                        params.put("id", idCerveza);
                        try {
                            con = new Connection(getApplicationContext(), "getOpiniones.php", params);
                            while (con.getRes() == null) ;
                            result = con.getRes();
                            if (!result.equals("")){
                                tvC.setTextColor(getResources().getColor(R.color.green));
                                WatchValues wv = new WatchValues(idPersona, idCerveza);
                                tr.setOnClickListener(wv);
                            } else tvC.setTextColor(getResources().getColor(R.color.red));
                        } catch (MalformedURLException e) {
                            e.printStackTrace();
                        }

                        tr.addView(tvC);

                        int index=0;
                        for(int j=0;j<table1.getChildCount();j++){
                            if(table1.getChildAt(j).getTag().toString().equals(this.idP)) {
                                index=j;
                                break;
                            }
                        }
                        table1.addView(tr, index+1);
                    }
                }
            } catch (MalformedURLException e) {
                e.printStackTrace();
            }
        }

    }

    ;

    private class Listener2 implements View.OnClickListener {

        int i;
        String idP;

        public Listener2(int i, String id) {
            this.idP = id;
            this.i = i;
        }

        @Override
        public void onClick(View v) {
            TableRow tr = (TableRow) personas[i];
            TextView tv = (TextView) tr.getChildAt(0);
            tv.setCompoundDrawablesWithIntrinsicBounds(getResources().getDrawable(R.drawable.ic_arrow_rigth_foreground), null, null, null);
            Listener1 l1 = new Listener1(i, idP);
            tv.setOnClickListener(l1);

            for(int j=0;j<table1.getChildCount();j++){
                TableRow aux = (TableRow) table1.getChildAt(j);
                TextView t = (TextView) aux.getChildAt(0);

                if(aux.getTag().toString().equals(idP+"_desplegable")){
                    table1.removeView(aux);
                    j--;
                }
            }
        }
    }

    private class WatchValues implements View.OnClickListener {

        public String idP,idCerveza;

        public WatchValues(String s1,String s2){
            this.idP = s1;
            this.idCerveza = s2;
        }

        @Override
        public void onClick(View v) {
            Map<String,String> params = new LinkedHashMap<>();
            params.put("p",idP);
            params.put("id",idCerveza);
            try {
                Connection c = new Connection(Cata.this,"getOpiniones.php",params);
                while(c.getRes()==null);
                String[] res = c.getRes().split(",");
                String aroma=res[0];
                String apariencia=res[1];
                String sabor=res[2];
                String cuerpo=res[3];
                String botellin=res[4];
                android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(Cata.this);
                builder.setCancelable(true);
                TextView t = new TextView(getApplicationContext());
                t.setTextSize(20);
                t.setText("Aroma: "+aroma+"\nApariencia: "+apariencia+"\nSabor: "+sabor+"\nCuerpo: "+cuerpo+"\nBotellín: "+botellin);
                t.setPadding(30,30,30,30);
                t.setVisibility(View.VISIBLE);
                builder.setView(t);
                builder.show();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            }
        }
    }
}

