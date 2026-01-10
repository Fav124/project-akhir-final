package com.example.deisa.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.core.view.isVisible
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.R
import com.example.deisa.models.Obat

class ObatAdapter(private val onClick: (Obat) -> Unit) : RecyclerView.Adapter<ObatAdapter.ViewHolder>() {

    private val list = mutableListOf<Obat>()

    fun setData(newList: List<Obat>) {
        list.clear()
        list.addAll(newList)
        notifyDataSetChanged()
    }

    inner class ViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val tvObatName: TextView = itemView.findViewById(R.id.tvObatName)
        val tvObatDesc: TextView = itemView.findViewById(R.id.tvObatDesc)
        val tvStock: TextView = itemView.findViewById(R.id.tvStock)
        val tvExpDate: TextView = itemView.findViewById(R.id.tvExpDate)
        val tvExpBadge: TextView = itemView.findViewById(R.id.tvExpBadge)

        fun bind(obat: Obat) {
            tvObatName.text = obat.namaObat
            tvObatDesc.text = "${obat.deskripsi ?: "-"} • ${obat.satuan ?: "-"}"
            tvStock.text = "${obat.stok} ${obat.satuan ?: ""}"
            
            // Expiry date
            if (obat.tanggalKadaluarsa != null) {
                tvExpDate.text = "Exp: ${obat.tanggalKadaluarsa}"
                tvExpDate.isVisible = true
            } else {
                tvExpDate.isVisible = false
            }
            
            // Alerts
            val alerts = obat.alerts
            if (alerts != null) {
                if (alerts.expired || alerts.expiringSoon) {
                    tvExpBadge.isVisible = true
                    if (alerts.expired) {
                        tvExpBadge.text = "EXPIRED"
                        tvExpBadge.setBackgroundColor(itemView.context.getColor(android.R.color.holo_red_dark))
                    } else {
                        tvExpBadge.text = "HAMPIR EXP"
                        tvExpBadge.setBackgroundColor(itemView.context.getColor(android.R.color.holo_orange_dark))
                    }
                } else {
                    tvExpBadge.isVisible = false
                }

                if (alerts.lowStock) {
                    tvStock.setTextColor(itemView.context.getColor(android.R.color.holo_orange_dark))
                } else {
                    tvStock.setTextColor(itemView.context.getColor(android.R.color.black))
                }
            } else {
                tvExpBadge.isVisible = false
            }
            
            itemView.setOnClickListener { onClick(obat) }
        }
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_obat, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        holder.bind(list[position])
    }

    override fun getItemCount(): Int = list.size
}
